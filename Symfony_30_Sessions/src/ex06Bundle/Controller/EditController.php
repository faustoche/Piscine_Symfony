<?php

namespace App\ex06Bundle\Controller;

use App\ex03Bundle\Entity\Post;
use App\ex03Bundle\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/post')]
class EditController extends AbstractController
{
    #[Route('/{id}/edit', name: 'app_post_edit')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function edit(Request $request, Post $post, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        
        $isAuthor = ($post->getAuthor() === $user);
        $hasReputation = ($user->getReputation() >= 9);
        $isAdmin = $this->isGranted('ROLE_ADMIN');

        // Si l'utilisateur n'est ni l'auteur, ni admin, et n'a pas 9 points => Erreur
        if (!$isAuthor && !$hasReputation && !$isAdmin) {
            $this->addFlash('error', 'You need 9 reputation points to edit other people\'s posts.');
            return $this->redirectToRoute('app_post_show', ['id' => $post->getId()]);
        }

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setLastEditor($user);
            $post->setLastEditDate(new \DateTime());

            $em->flush();

            $this->addFlash('success', 'Post edited successfully!');
            return $this->redirectToRoute('app_post_show', ['id' => $post->getId()]);
        }

        return $this->render('ex06/edit.html.twig', [
            'form' => $form->createView(),
            'post' => $post
        ]);
    }
}