<?php

namespace App\e06Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\DBAL\Connection;
use Symfony\Component\Routing\Attribute\Route;


class DefaultController extends AbstractController {
	#[Route('/e06/Default', name:'e06_index', methods: ['GET'])]
	public function indexAction() {
		return $this->render('e06/index.html.twig');
	}
	
	#[Route('/e06/create-table', name:'e06_create_table', methods: ['POST'])]
	public function createTableAction(Connection $connection) {
		$sqlInstruction = "CREATE TABLE IF NOT EXISTS persons (
			id INT AUTO_INCREMENT PRIMARY KEY,
			username VARCHAR(255) UNIQUE NOT NULL,
			name VARCHAR(255) NOT NULL,
			email VARCHAR(255) UNIQUE NOT NULL,
			enable BOOLEAN DEFAULT TRUE,
			birthdate DATETIME,
			address TEXT
			)";
		
		try {
			$connection->executeStatement($sqlInstruction);
			$this->addFlash('success', 'Success!');
		} catch (\Exception $error) {
			$this->addFlash('error', $error->getMessage());
		}

		return $this->redirectToRoute('e06_index');
	}
}