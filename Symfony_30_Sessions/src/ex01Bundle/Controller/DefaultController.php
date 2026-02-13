<?php

namespace App\ex01Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController {
	// on a deja prefixe dans routes
	#[Route('/', name: 'app_homepage')]
	public function index(): Response {
		return $this->render('ex01/index.html.twig');
	}
}