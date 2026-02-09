<?php

namespace App\e08Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\DBAL\Connection;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class e08Controller extends AbstractController {

	#[Route('/e08', name:'e08_controller_index')]
	public function indexAction(Connection $connection, Request $request): Response {
		// on recupere les données si la table existe
		$persons = [];
		try {
			// utilisation de person au lieu de person sql
			$persons = $connection->fetchAllAssociative("SELECT * FROM persons");
		} catch (\Exception $e) {
			// est-ce que la table existe?
			$this->addFlash('warning', 'Table does not exist yet. Please create it using the link.');
		}

		$form = $this->createFormBuilder()
			->add('username', TextType::class)
			->add('name', TextType::class)
			->add('email', TextType::class)
			->add('enable', CheckboxType::class, ['required' => false])
			->add('birthdate', DateType::class, ['widget' => 'single_text'])
			->add('save', SubmitType::class, ['label' => 'Add'])
			->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$data = $form->getData();
			
			try {
				// insertion pour la table person
				$sqlInsert = "INSERT INTO persons (username, name, email, enable, birthdate)
							VALUES (:username, :name, :email, :enable, :birthdate)";
				
				$connection->executeStatement($sqlInsert, [
					'username' => $data['username'],
					'name' => $data['name'],
					'email' => $data['email'],
					'enable' => $data['enable'] ? 1 : 0,
					'birthdate' => $data['birthdate'] ? $data['birthdate']->format('Y-m-d') : null,
				]);
				$this->addFlash('success', 'User added successfully!');
				return $this->redirectToRoute('e08_controller_index');
			} catch (\Exception $e) {
				$this->addFlash('error', 'SQL Error: ' . $e->getMessage());
			}
		}

		return $this->render('e08/index.html.twig', [
			'form' => $form->createView(),
			'persons' => $persons
		]);
	}

	// creation de la table avec le lien
	#[Route('/e08/create-table', name:'e08_create_table')]
	public function createTableAction(Connection $connection): Response {

		$sql = "CREATE TABLE IF NOT EXISTS persons (
			id INTEGER PRIMARY KEY AUTOINCREMENT, 
			username VARCHAR(255) UNIQUE NOT NULL,
			name VARCHAR(255) NOT NULL,
			email VARCHAR(255) UNIQUE NOT NULL,
			enable BOOLEAN DEFAULT TRUE,
			birthdate DATETIME
		)";

		try {
			$connection->executeStatement($sql);
			$this->addFlash('success', 'Table "persons" created successfully!');
		} catch (\Exception $e) {
			$this->addFlash('error', 'Error creating table: ' . $e->getMessage());
		}

		return $this->redirectToRoute('e08_controller_index');
	}

	// ajout d'une colonne
	#[Route('/e08/add-column', name:'e08_add_column')]
	public function addColumnAction(Connection $connection): Response {

		$sql = "ALTER TABLE persons ADD COLUMN marital_status VARCHAR(20) DEFAULT 'single'";

		try {
			$connection->executeStatement($sql);
			$this->addFlash('success', 'Column "marital_status" added successfully!');
		} catch (\Exception $e) {
			$this->addFlash('error', 'Error altering table: ' . $e->getMessage());
		}

		return $this->redirectToRoute('e08_controller_index');
	}

	// creation des relations!
	#[Route('/e08/create-relations', name:'e08_create_relations')]
	public function createRelationsAction(Connection $connection): Response {
		try {

			$sqlAddresses = "CREATE TABLE IF NOT EXISTS addresses (
				id INTEGER PRIMARY KEY AUTOINCREMENT,
				person_id INTEGER NOT NULL,
				street VARCHAR(255),
				city VARCHAR(100),
				FOREIGN KEY (person_id) REFERENCES persons(id) ON DELETE CASCADE
			)";
			$connection->executeStatement($sqlAddresses);

			$sqlBank = "CREATE TABLE IF NOT EXISTS bank_accounts (
				id INTEGER PRIMARY KEY AUTOINCREMENT,
				person_id INTEGER NOT NULL UNIQUE,
				iban VARCHAR(34) NOT NULL,
				bank_name VARCHAR(100),
				FOREIGN KEY (person_id) REFERENCES persons(id) ON DELETE CASCADE
			)";
			$connection->executeStatement($sqlBank);

			$this->addFlash('success', 'Tables "addresses" and "bank_accounts" created with relations!');
		} catch (\Exception $e) {
			$this->addFlash('error', 'Error creating relations: ' . $e->getMessage());
		}

		return $this->redirectToRoute('e08_controller_index');
	}

	#[Route('e08/delete/{id}', name:'e08_delete')]
	public function deleteAction(Connection $connection, int $id): Response {
		try {
			$connection->executeStatement("DELETE FROM persons WHERE id = :id", ['id' => $id]);
			$this->addFlash('success', 'Entry deleted successfully!');
		} catch (\Exception $e) {
			$this->addFlash('error', 'SQL Error: ' . $e->getMessage());
		}
		return $this->redirectToRoute('e08_controller_index');
	}

	#[Route('e08/update/{id}', name:'e08_update', methods: ['GET', 'POST'])]
	public function updateAction(Connection $connection, Request $request, int $id): Response {
		## fetch la data actuelle dans la table persons
		$sql = "SELECT * FROM persons WHERE id = :id";
		$person = $connection->fetchAssociative($sql, ['id' => $id]);

		if (!$person) {
			$this->addFlash('error', 'Person not found');
			return $this->redirectToRoute('e08_controller_index');
		}

		## preparation de la data pour le formulaire
		if (!empty($person['birthdate'])) {
			$person['birthdate'] = new \DateTime($person['birthdate']);
		}
		$person['enable'] = (bool)$person['enable'];

		$formBuilder = $this->createFormBuilder($person)
			->add('username', TextType::class)
			->add('name', TextType::class)
			->add('email', TextType::class)
			->add('enable', CheckboxType::class, ['required' => false])
			->add('birthdate', DateType::class, ['widget' => 'single_text']);
			
		$form = $formBuilder->add('save', SubmitType::class, ['label' => 'Update'])->getForm();
		
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$data = $form->getData();

			### update les infos
			$sqlUpdate = "UPDATE persons SET
				username = :username,
				name = :name,
				email = :email,
				enable = :enable,
				birthdate = :birthdate
				WHERE id = :id";

			try {
				$connection->executeStatement($sqlUpdate, [
					'username' => $data['username'],
					'name' => $data['name'],
					'email' => $data['email'],
					'enable' => $data['enable'] ? 1 : 0,
					'birthdate' => $data['birthdate'] ? $data['birthdate']->format('Y-m-d') : null,
					'id' => $id
				]);

				$this->addFlash('success', 'User updated successfully!');
				return $this->redirectToRoute('e08_controller_index');
			} catch (\Exception $error) {
				$this->addFlash('error', 'Could not update: ' . $error->getMessage());
			}
		}
		return $this->render('e08/update.html.twig', [
			'form' => $form->createView()
		]);
	}
}