<?php

namespace App\ex03Bundle\Controller;

use App\ex03Bundle\Entity\Post;
use App\ex03Bundle\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/post')]
class PostController extends AbstractController
{
    #[Route('/new', name: 'app_post_new')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')] // uniquement pour les connectes
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // liaison auteur connece
            $post->setAuthor($this->getUser());
            
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('ex03/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_post_show')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')] // uniquement pour ceux connectes
    public function show(Post $post): Response
    {
        return $this->render('ex03/show.html.twig', [
            'post' => $post,
        ]);
    }
}