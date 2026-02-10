<?php

namespace App\ex02Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\DBAL\Connection;
use Symfony\Component\Routing\Attribute\Route;


class DefaultController extends AbstractController {
	#[Route('/ex02/Default', name:'ex02_index', methods: ['GET'])]
	public function indexAction() {
		return $this->render('ex02/index.html.twig');
	}
	
	#[Route('/ex02/create-table', name:'ex02_create_table', methods: ['POST'])]
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

		return $this->redirectToRoute('ex02_index');
	}
}