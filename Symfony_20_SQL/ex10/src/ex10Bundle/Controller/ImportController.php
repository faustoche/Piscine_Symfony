<?php

namespace App\ex10Bundle\Controller;

use App\ex10Bundle\Entity\OrmData;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;

class ImportController extends AbstractController
{
    #[Route('/ex10/import', name: 'ex10_import_view')]
    public function index(Connection $connection, EntityManagerInterface $em): Response
    {
        // 1. Récupérer les données ORM
        $ormRepository = $em->getRepository(OrmData::class);
        $ormData = $ormRepository->findAll();

        // 2. Récupérer les données SQL via une requête brute
        $sql = "SELECT * FROM sql_data";
        $sqlData = $connection->fetchAllAssociative($sql);

        return $this->render('index.html.twig', [
            'ormData' => $ormData,
            'sqlData' => $sqlData,
        ]);
    }

    #[Route('/ex10/import/run', name: 'ex10_import_run')]
    public function runImport(KernelInterface $kernel, EntityManagerInterface $em, Connection $connection): Response
    {
        // Chemin vers le fichier source.txt à la racine du projet
        $filePath = $kernel->getProjectDir() . '/source.txt';

        if (!file_exists($filePath)) {
            $this->addFlash('error', 'Le fichier source.txt est introuvable à la racine !');
            return $this->redirectToRoute('ex10_import_view');
        }

        // Lecture du fichier ligne par ligne
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        $em->beginTransaction(); // Optionnel : pour sécuriser les deux opérations
        try {
            foreach ($lines as $line) {
                $line = trim($line); // Nettoyage

                // --- PARTIE ORM ---
                $entity = new OrmData();
                $entity->setContent($line);
                $em->persist($entity);

                // --- PARTIE SQL ---
                // Utilisation de DBAL pour faire du SQL brut sécurisé (Prepared Statement)
                $sql = "INSERT INTO sql_data (raw_content) VALUES (:content)";
                $connection->executeStatement($sql, ['content' => $line]);
            }

            // Exécution des requêtes ORM
            $em->flush();
            $em->commit();

            $this->addFlash('success', 'Importation réussie dans les deux tables (SQL & ORM) !');

        } catch (\Exception $e) {
            $em->rollback();
            $this->addFlash('error', 'Erreur lors de l\'import : ' . $e->getMessage());
        }

        return $this->redirectToRoute('ex10_import_view');
    }
    
    // Ajout d'une route pour nettoyer les tables (pratique pour tester)
    #[Route('/ex10/import/clear', name: 'ex10_import_clear')]
    public function clearData(EntityManagerInterface $em, Connection $connection): Response
    {
        // Vider la table ORM
        $cmd = $em->getClassMetadata(OrmData::class);
        $connection->executeStatement('TRUNCATE TABLE ' . $cmd->getTableName());
        
        // Vider la table SQL
        $connection->executeStatement('TRUNCATE TABLE sql_data');

        $this->addFlash('warning', 'Toutes les données ont été effacées.');
        return $this->redirectToRoute('ex10_import_view');
    }
}