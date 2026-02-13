<?php

namespace App\ex01Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\ex04Bundle\Service\AnonymousManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\ex03Bundle\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

class DefaultController extends AbstractController {
	// on a deja prefixe dans routes
	#[Route('/', name: 'app_homepage')]
	public function index(EntityManagerInterface $entity, AnonymousManager $anonymousManager): Response {

		//ex04 gestion de l'anonyme
		$anonymous = null;

		// si le user est pas connecte
		if (!$this->getUser()) {
			$anonymous = $anonymousManager->handleAnonymousUser();
		}


		// recuperation des posts!
		$posts = $entity->getRepository(Post::class)->findBy([], ['created_date' => 'DESC']);
		return $this->render('ex01/index.html.twig', [
			'posts' => $posts,
			'anonymous_info' => $anonymous,
		]);
	}
}