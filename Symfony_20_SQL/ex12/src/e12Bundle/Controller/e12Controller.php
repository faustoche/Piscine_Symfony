<?php

namespace App\e12Bundle\Controller;

use App\e12Bundle\Entity\Person;
use App\e12Bundle\Entity\Address;
use App\e12Bundle\Entity\BankAccount;
use App\e12Bundle\Form\PersonType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use App\e12Bundle\Repository\PersonRepository;


class e12Controller extends AbstractController {

	#[Route('/e12', name:'e12_index')]

	public function indexAction(Request $request, PersonRepository $repo, EntityManagerInterface $em): Response {
        
        $filter = $request->query->get('filter');
        $sort = $request->query->get('sort', 'id');
        $order = $request->query->get('order', 'ASC');
        $persons = $repo->findByFilterAndSort($filter, $sort, $order);
        $person = new Person();

		$person->setAddress(new Address());
        $person->setBankAccount(new BankAccount());

        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em->persist($person);
                $em->flush();
                $this->addFlash('success', 'Saved via ORM!');
                return $this->redirectToRoute('e12_index');
            } catch (\Exception $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('e12/index.html.twig', [
            'form' => $form->createView(),
            'persons' => $persons,
            'current_filter' => $filter,
            'current_sort' => $sort,
            'current_order' => $order
        ]);
    }

	## une nouvelle fonction pour l'action de delete
	#[Route('/e12/delete/{id}', name: 'e12_delete', methods: ['POST'])]
	public function deleteAction(int $id, EntityManagerInterface $entity): Response {
		$person = $entity->getRepository(Person::class)->find($id);

		if (!$person) {
			$this->addFlash('error', 'Error: Element not found');
			return $this->redirectToRoute('e12_index');
		}

		try {
			## using ORM command to delete infomation
			$entity->remove($person);
			$entity->flush();
			$this->addFlash('success', 'Person deleted successfully!');
		} catch (\Exception $error) {
			$this->addFlash('error', 'Error deleting element: ' . $error->getMessage());
		}

		return $this->redirectToRoute('e12_index');
	}

	#[Route('/e12/update/{id}', name: 'e12_update', methods: ['GET', 'POST'])]
	public function updateAction(Request $request, int $id, EntityManagerInterface $entity): Response {
		// recuperation de lobjet via orm
		$person = $entity->getRepository(Person::class)->find($id);

		if (!$person) {
			$this->addFlash('error', 'Error: Element not found');
			return $this->redirectToRoute('e12_index');
		}

		// creation du formulaire 
		$form = $this->createForm(PersonType::class, $person);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			try {
				// flush exxecite les chamgements et les transmets a update
				$entity->flush();

				$this->addFlash('success', 'Person updated successfully!');
				return $this->redirectToRoute('e12_index');

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