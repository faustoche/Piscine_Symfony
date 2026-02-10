<?php

namespace App\e06Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\DBAL\Connection;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class e06Controller extends AbstractController {

    ## j'ai besoin de la connexion pour faire du sql direct et la requete http pour savoir si le formulaire a ete soumis
    #[Route('/e06', name:'e06_controller_index')]
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
            return $this->redirectToRoute('e06_controller_index');
        }

        $persons = $connection->fetchAllAssociative("SELECT * FROM persons_sql");
        return $this->render('e06/index.html.twig', [
            'form' => $form->createView(),
            'persons' => $persons
        ]);
    }


    #### Nouvelle route pour supprimer un élément
    #[Route('e06/delete/{id}', name:'e06_delete')]

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
        return $this->redirectToRoute('e06_controller_index');
    }


    ### nouvelle fonction pour l'update
    #[Route('e06/update/{id}', name:'e06_update', methods: ['GET', 'POST'])]
    public function updateAction(Connection $connection, Request $request, int $id): Response {
        ## fetch la data actuelle
        $sql = "SELECT * FROM persons_sql WHERE id = :id";
        $person = $connection->fetchAssociative($sql, ['id' => $id]);

        if (!$person) {
            $this->addFlash('error', 'Person not found');
            return $this->redirectToRoute('e06_controller_index');
        }

        ## preparation de la data pour le formulaire
        if (!empty($person['birthdate'])) {
            $person['birthdate'] = new \DateTime($person['birthdate']);
        }

        ##conversion
        $person['enable'] = (bool)$person['enable'];

        ## creation du formulaire avec la data existante
        $form = $this->createFormBuilder($person)
            ->add('username', TextType::class)
            ->add('name', TextType::class)
            ->add('email', TextType::class)
            ->add('enable', CheckboxType::class, ['required' => false])
            ->add('birthdate', DateType::class, ['widget' => 'single_text'])
            ->add('address', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Update'])
            ->getForm();
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            ### update les infos
            $sqlUpdate = "UPDATE persons_sql SET
                username = :username,
                name = :name,
                email = :email,
                enable = :enable,
                birthdate = :birthdate,
                address = :address
                WHERE id = :id";

            try {
                $connection->executeStatement($sqlUpdate, [
                    'username' => $data['username'],
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'enable' => $data['enable'] ? 1 : 0,
                    'birthdate' => $data['birthdate'] ? $data['birthdate']->format('Y-m-d') : null,
                    'address' => $data['address'],
                    'id' => $id
                ]);

                $this->addFlash('success', 'User updated successfully!');
                return $this->redirectToRoute('e06_controller_index');
            } catch (\Exception $error) {
                $this->addFlash('error', 'Could not update: ' . $error->getMessage());
            }
        }
        return $this->render('e06/update.html.twig', [
            'form' => $form->createView()
        ]);
    }
}