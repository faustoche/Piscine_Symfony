<?php

namespace App\ex12Bundle\Controller;

use App\ex12Bundle\Entity\Person;
use App\ex12Bundle\Entity\Address;
use App\ex12Bundle\Entity\BankAccount;
use App\ex12Bundle\Form\PersonType;
use App\ex12Bundle\Repository\PersonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ex12Controller extends AbstractController {

    #[Route('/ex12', name:'ex12_index', methods: ['GET', 'POST'])]
    #[Route('/ex12/', name:'ex12_index_slash', methods: ['GET', 'POST'])]
    public function indexAction(Request $request, PersonRepository $repo): Response {
        
        // 1. On utilise la requête spéciale du Repository (Jointure, Tri, Condition)
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
                // RÈGLE 144 : On utilise $repo->save() et NON $em->persist/flush()
                $repo->save($person);
                $this->addFlash('success', 'Saved via ORM!');
                return $this->redirectToRoute('ex12_index');
            } catch (\Exception $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('ex12/index.html.twig', [
            'form' => $form->createView(),
            'persons' => $persons,
            'current_filter' => $filter,
            'current_sort' => $sort,
            'current_order' => $order
        ]);
    }

    #[Route('/ex12/delete/{id}', name: 'ex12_delete', methods: ['POST'])]
    public function deleteAction(int $id, PersonRepository $repo): Response {
        $person = $repo->find($id);

        if (!$person) {
            $this->addFlash('error', 'Error: Element not found');
            return $this->redirectToRoute('ex12_index');
        }

        try {
            // RÈGLE 144 : On utilise $repo->remove() et NON $em->remove/flush()
            $repo->remove($person);
            $this->addFlash('success', 'Person deleted successfully!');
        } catch (\Exception $error) {
            $this->addFlash('error', 'Error deleting element');
        }

        return $this->redirectToRoute('ex12_index');
    }

    #[Route('/ex12/update/{id}', name: 'ex12_update', methods: ['GET', 'POST'])]
    public function updateAction(Request $request, int $id, PersonRepository $repo): Response {
        $person = $repo->find($id);

        if (!$person) {
            $this->addFlash('error', 'Error: Element not found');
            return $this->redirectToRoute('ex12_index');
        }

        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // RÈGLE 144 : On utilise $repo->update() et NON $em->flush()
                $repo->update();
                $this->addFlash('success', 'Person updated successfully!');
                return $this->redirectToRoute('ex12_index');
            } catch (\Exception $error) {
                $this->addFlash('error', 'Error updating element');
            }
        }

        return $this->render('ex12/update.html.twig', [
            'form' => $form->createView(),
            'person' => $person
        ]);
    }
}