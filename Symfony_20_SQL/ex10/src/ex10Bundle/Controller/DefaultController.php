<?php

namespace App\ex10Bundle\Controller;

use App\ex10Bundle\Entity\OrmData;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController {

    #[Route('/ex10', name:'ex10_index', methods:['GET'])]
    public function indexAction(Connection $connection, EntityManagerInterface $entity): Response {
        
        // 1. Récupération des données via ORM
        // On va chercher toutes les entrées de la table orm_data
        $ormData = $entity->getRepository(OrmData::class)->findAll();

        // 2. Récupération des données via SQL (DBAL)
        // On fait une requête brute pour récupérer le contenu de la table sql_data
        // (Assurez-vous que la table 'sql_data' existe bien, voir ImportController pour la création si besoin)
        try {
            $sqlData = $connection->fetchAllAssociative("SELECT * FROM sql_data");
        } catch (\Exception $e) {
            // Si la table n'existe pas encore, on envoie un tableau vide pour éviter le crash
            $sqlData = [];
        }

        // 3. On envoie les deux variables à la vue
        return $this->render('index.html.twig', [
            'ormData' => $ormData, // C'est cette variable qui manquait !
            'sqlData' => $sqlData  // Et celle-ci pour la colonne de droite
        ]);
    }
}