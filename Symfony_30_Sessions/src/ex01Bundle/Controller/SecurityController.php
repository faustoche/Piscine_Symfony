<?php

namespace App\ex01Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController {
	#[Route('/login', name: 'app_login')]
	public function login(AuthenticationUtils $authenticationUtils): Response
	{
		// si l'utilisateur est deja connecte on le redigire vers l'accueil
		if ($this->getUser()) {
			return $this->redirectToRoute('app_homepage');
		}

		// recuperation de l'erreur de connection
		$error = $authenticationUtils->getLastAuthenticationError();

		// recuperer le dernier nom d[utilisation] saisi
		$lastUsername = $authenticationUtils->getLastUsername();

		return $this->render('ex01/login.html.twig', [
			'last_username' => $lastUsername,
			'error' => $error,
		]);
	}

	#[Route('/logout', name: 'app_logout')]
	public function logout(): void {
		// l'exception sera intercepter par le composant de seucirte
		throw new \LogicException();
	}
}