<?php

namespace App\ex14Bundle\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ex14Controller extends AbstractController
{
    #[Route('/ex14', name: 'ex14_index', methods: ['GET', 'POST'])]
    #[Route('/ex14/', name: 'ex14_index_slash', methods: ['GET', 'POST'])]
    public function index(Request $request, Connection $connection): Response
    {
        $schemaManager = $connection->createSchemaManager();
        $tableExists = $schemaManager->tablesExist(['sql_test_14']);

        // Création du formulaire via FormBuilder (Règle globale)
        // On désactive le CSRF pour que l'injection ne soit pas bloquée par le jeton
        $form = $this->createFormBuilder(null, ['csrf_protection' => false])
            ->add('data', TextType::class, [
                'attr' => ['id' => 'dataInput', 'placeholder' => 'Type your input...'],
                'required' => true
            ])
            ->add('save', SubmitType::class, ['label' => 'Send (Launch Injection)'])
            ->getForm();

        $form->handleRequest($request);

        // Traitement de l'insertion vulnérable
        if ($form->isSubmitted() && $form->isValid()) {
            $inputData = $form->get('data')->getData();
            
            // CONCATÉNATION DIRECTE : Faille d'injection SQL volontaire
            $sql = "INSERT INTO sql_test_14 (data) VALUES ('" . $inputData . "')";

            try {
                $pdo = $connection->getNativeConnection();
                $pdo->exec($sql); // Permet l'exécution de requêtes multiples injectées
                $this->addFlash('success', 'Donnée insérée.');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erreur SQL : ' . $e->getMessage());
            }
            return $this->redirectToRoute('ex14_index');
        }

        $data = $tableExists ? $connection->fetchAllAssociative("SELECT * FROM sql_test_14") : [];

        return $this->render('ex14/index.html.twig', [
            'table_exists' => $tableExists,
            'data' => $data,
            'form' => $form->createView()
        ]);
    }

    #[Route('/ex14/create-table', name: 'ex14_create_table', methods: ['GET'])]
    public function createTable(Connection $connection): Response
    {
        $sql = "CREATE TABLE IF NOT EXISTS sql_test_14 (id INTEGER PRIMARY KEY AUTOINCREMENT, data VARCHAR(255))";
        try {
            $connection->executeStatement($sql);
            $this->addFlash('success', 'Table "sql_test_14" créée.');
        } catch (\Exception $e) {
            $this->addFlash('error', $e->getMessage());
        }
        return $this->redirectToRoute('ex14_index');
    }
}