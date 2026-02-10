<?php

namespace App\ex04Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\DBAL\Connection;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ex04Controller extends AbstractController {

    ## j'ai besoin de la connexion pour faire du sql direct et la requete http pour savoir si le formulaire a ete soumis
    #[Route('/ex04', name:'ex04_controller_index')]
    #[Route('/ex04/', name:'ex04_controller_index_slash', methods: ['GET', 'POST'])]
    public function indexAction(Connection $connection, Request $request): Response {
        $sql = "CREATE TABLE IF NOT EXISTS persons_sql (
			id INTEGER PRIMARY KEY AUTOINCREMENT,
			username VARCHAR(255) UNIQUE NOT NULL,
			name VARCHAR(255) NOT NULL,
			email VARCHAR(255) UNIQUE NOT NULL,
			enable BOOLEAN DEFAULT TRUE,
			birthdate DATETIME,
			address TEXT
			)";
        
        ## execution de la creation ici
        $connection->executeStatement($sql);

        ## on crée le formulaire en ajoutant chaque champs
        $form = $this->createFormBuilder()
            ->add('username', TextType::class)
            ->add('name', TextType::class)
            ->add('email', TextType::class)
            ->add('enable', CheckboxType::class, ['required' => false])
            ->add('birthdate', DateType::class, ['widget' => 'single_text'])
            ->add('address', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Add'])
            ->getForm();


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            ## on insere via commande sql
            ## on garde le insert or ignore si jamais y a un doublon -> on passe à l'id suivant
            $sqlInsert = "INSERT OR IGNORE INTO persons_sql (username, name, email, enable, birthdate, address)
                        VALUES (:username, :name, :email, :enable, :birthdate, :address)";

            $connection->executeStatement($sqlInsert, [
                'username' => $data['username'],
                'name' => $data['name'],
                'email' => $data['email'],
                'enable' => $data['enable'] ? 1 : 0,
                'birthdate' => $data['birthdate'] ? $data['birthdate']->format('Y-m-d') : null,
                'address' => $data['address']
            ]);

            ## a rajouter aussi dans le 02
            $this->addFlash('success', 'User was added with success!'); 
            return $this->redirectToRoute('ex04_controller_index');
        }

        $persons = $connection->fetchAllAssociative("SELECT * FROM persons_sql");
        return $this->render('ex04/index.html.twig', [
            'form' => $form->createView(),
            'persons' => $persons
        ]);
    }


    #### Nouvelle route pour supprimer un élément
    #[Route('/ex04/delete/{id}', name:'ex04_delete', methods: ['GET'])]

    public function deleteAction(Connection $connection, int $id): Response {
        
        ## 1. on vérifier que l'user existe dans la base
        $sql = "SELECT id FROM persons_sql WHERE id = :id";

        ## 2. fetchOne va renvoyer la valeur de la colonne ou false
        $exist = $connection->fetchOne($sql, ['id' => $id]);

        if (!$exist) {
            $this->addFlash('error', 'Error: cannot delete, ID doesn\'t exist');
        } else {

            ## vraie suppression
            try {
                $sqlDelete = "DELETE FROM persons_sql WHERE id = :id";
                $connection->executeStatement($sqlDelete, ['id' => $id]);

                $this->addFlash('success', 'Entry was delete with success!');
            } catch (\Exception $error) {
                $this->addFlash('error', 'SQL Error: ' . $error->getMessage());
            }
        }
        return $this->redirectToRoute('ex04_controller_index');
    }
}