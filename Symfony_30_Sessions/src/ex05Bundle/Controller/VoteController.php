<?php

namespace App\ex05Bundle\Controller;

use App\ex03Bundle\Entity\Post;
use App\ex05Bundle\Entity\Vote;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/vote')]
class VoteController extends AbstractController
{
    #[Route('/{id}/{type}', name: 'app_vote')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function vote(Post $post, string $type, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $reputation = $user->getReputation();
        $isAdmin = in_array('ROLE_ADMIN', $user->getRoles());

        // Vérification des privilèges
        if ($type === 'like' && $reputation < 3 && !$isAdmin) {
            $this->addFlash('error', 'You need at least 3 reputation points to like.');
            return $this->redirectToRoute('app_post_show', ['id' => $post->getId()]);
        }

        if ($type === 'dislike' && $reputation < 6 && !$isAdmin) {
            $this->addFlash('error', 'You need at least 6 reputation points to dislike.');
            return $this->redirectToRoute('app_post_show', ['id' => $post->getId()]);
        }

        // Interdiction de voter pour soi-même
        if ($post->getAuthor() === $user) {
            $this->addFlash('error', 'You cannot vote for your own post!');
            return $this->redirectToRoute('app_post_show', ['id' => $post->getId()]);
        }

        $voteValue = ($type === 'like') ? 1 : -1;
        $author = $post->getAuthor();

        // Gestion du vote existant ou nouveau
        $existingVote = $em->getRepository(Vote::class)->findOneBy([
            'post' => $post,
            'voter' => $user
        ]);

        if ($existingVote) {
            if ($existingVote->getValue() !== $voteValue) {
                // Changement de vote : on annule l'ancien impact et on applique le nouveau
                $author->setReputation($author->getReputation() - $existingVote->getValue() + $voteValue);
                $existingVote->setValue($voteValue);
            }
        } else {
            // Nouveau vote
            $vote = new Vote();
            $vote->setPost($post);
            $vote->setVoter($user);
            $vote->setValue($voteValue);
            $em->persist($vote);
            
            $author->setReputation($author->getReputation() + $voteValue);
        }

        $em->flush();
        return $this->redirectToRoute('app_post_show', ['id' => $post->getId()]);
    }
}