<?php

namespace App\e14Bundle\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class e14Controller extends AbstractController
{
    #[Route('/e14', name: 'e14_index')]
    public function index(Connection $connection): Response
    {
        // On utilise DBAL pour vérifier si la table existe sans utiliser d'Entité
        $schemaManager = $connection->createSchemaManager();
        $tableExists = $schemaManager->tablesExist(['sql_test_14']);

        $data = [];
        if ($tableExists) {
            // Récupération des données pour voir le résultat de l'injection
            $data = $connection->fetchAllAssociative("SELECT * FROM sql_test_14");
        }

        return $this->render('e14/index.html.twig', [
            'table_exists' => $tableExists,
            'data' => $data
        ]);
    }

    #[Route('/e14/create-table', name: 'e14_create_table')]
    public function createTable(Connection $connection): Response
    {
        $sql = "CREATE TABLE IF NOT EXISTS sql_test_14 (
            id INTEGER PRIMARY KEY AUTOINCREMENT, 
            data VARCHAR(255)
        )";
        
        try {
            $connection->executeStatement($sql);
            $this->addFlash('success', 'Table "sql_test_14" créée avec succès.');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Erreur : ' . $e->getMessage());
        }

        return $this->redirectToRoute('e14_index');
    }

    #[Route('/e14/insert', name: 'e14_insert', methods: ['POST'])]
    public function insert(Request $request, Connection $connection): Response
    {
        $inputData = $request->request->get('data');


		#### ici la faille d'injection
        $sql = "INSERT INTO sql_test_14 (data) VALUES ('" . $inputData . "')";

        try {
            $connection->executeStatement($sql);
            $this->addFlash('success', 'Donnée insérée.');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Erreur SQL : ' . $e->getMessage());
        }

        return $this->redirectToRoute('e14_index');
    }
}