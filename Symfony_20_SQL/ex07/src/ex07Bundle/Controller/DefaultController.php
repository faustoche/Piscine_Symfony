<?php

namespace App\ex07Bundle\Controller;

use App\ex07Bundle\Entity\Person;
use App\ex07Bundle\Form\PersonType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class DefaultController extends AbstractController {

	#[Route('/ex07', name:'ex07_index', methods:['GET', 'POST'])]

	public function indexAction(Request $request, EntityManagerInterface $entity) : Response {

		## je récupère la liste existante
		$persons = $entity->getRepository(Person::class)->findAll();

		## on créé un formulaire
		$person = new Person();
		$form = $this->createForm(PersonType::class, $person);

		## on submit le formulaire
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			try {

				## ne fais pas de query database
				$entity->getRepository(Person::class)->save($person);

				$this->addFlash('success', 'Added a new person with success!');
				return $this->redirectToRoute('ex07_index');

			} catch (UniqueConstraintViolationException $error) {
				##on gere ici l'erreur du doublon sans crash
				$this->addFlash('error', "Error: Name or email already in use");

			} catch (\Exception $error) {
				$this->addFlash('error', 'Error: ' . $error->getMessage());
			}
		}

		return $this->render('index.html.twig', [
			'form' => $form->createView(),
			'persons' => $persons
		]);
	}

	## une nouvelle fonction pour l'action de delete
	#[Route('/ex07/delete/{id}', name: 'ex07_delete', methods: ['POST'])]
	public function deleteAction(int $id, EntityManagerInterface $entity): Response {
		$person = $entity->getRepository(Person::class)->find($id);

		if (!$person) {
			$this->addFlash('error', 'Error: Element not found');
			return $this->redirectToRoute('ex07_index');
		}

		try {
			## using ORM command to delete infomation
			$entity->getRepository(Person::class)->remove($person);
			$this->addFlash('success', 'Person deleted successfully!');
		} catch (\Exception $error) {
			$this->addFlash('error', 'Error deleting element: ' . $error->getMessage());
		}

		return $this->redirectToRoute('ex07_index');
	}

	#[Route('/ex07/update/{id}', name: 'ex07_update', methods: ['GET', 'POST'])]
	public function updateAction(Request $request, int $id, EntityManagerInterface $entity): Response {
		// recuperation de lobjet via orm
		$person = $entity->getRepository(Person::class)->find($id);

		if (!$person) {
			$this->addFlash('error', 'Error: Element not found');
			return $this->redirectToRoute('ex07_index');
		}

		// creation du formulaire 
		$form = $this->createForm(PersonType::class, $person);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			try {
				// flush exxecite les chamgements et les transmets a update
				$entity->getRepository(Person::class)->update();

				$this->addFlash('success', 'Person updated successfully!');
				return $this->redirectToRoute('ex07_index');

			} catch (UniqueConstraintViolationException $error) {

				$this->addFlash('error', "Error: Name or email already in use");
			
			} catch (\Exception $error) {

				$this->addFlash('error', 'Error updating element: ' . $error->getMessage());
			}
		}

		return $this->render('update.html.twig', [
			'form' => $form->createView(),
			'person' => $person
		]);
	}
}