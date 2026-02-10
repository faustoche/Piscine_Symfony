<?php

namespace App\e03Bundle\Controller;

use App\e03Bundle\Entity\Person;
use App\e03Bundle\Form\PersonType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class DefaultController extends AbstractController {

    #[Route('/e03', name:'e03_index', methods:['GET', 'POST'])]

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
                $entity->persist($person);
                $entity->flush();

                $this->addFlash('success', 'Added a new person with success!');
                return $this->redirectToRoute('e03_index');

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
}