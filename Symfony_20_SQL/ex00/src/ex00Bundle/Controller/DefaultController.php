<?php

namespace App\ex00Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\DBAL\Connection;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends AbstractController {
	#[Route('/ex00', name:'ex00_index', methods: ['GET'])]
	public function indexAction() {
		$form = $this->createFormBuilder()
			->add('create', SubmitType::class, ['label' => 'Create table'])
			->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			return $this->redirectToRoute('ex00_create_table');
		}

		return $this->render('ex00/index.html.twig', [
			'form' => $form->createView(),
		]);
	}
	
	#[Route('/ex00/create-table', name:'ex00_create_table', methods: ['POST'])]
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

		return $this->redirectToRoute('ex00_index');
	}
}