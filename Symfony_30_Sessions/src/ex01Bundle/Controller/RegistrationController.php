<?php

namespace App\ex01Bundle\Controller;

use App\ex01Bundle\Entity\User;
use App\ex01Bundle\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
	#[Route('/register', name: 'app_register')]
	public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
	{
		$user = new User();
		$form = $this->createForm(RegistrationType::class, $user);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			// on recupere le mot de passe en clair avec le form
			$plainPassword = $form->get('password')->getData();

			// on le hashe
			$hashedPassword = $userPasswordHasher->hashPassword(
				$user,
				$plainPassword,
			);

			// on remplace le mdp en clair par celui hashe dans user
			$user->setPassword($hashedPassword);

			// on sauvegarde le tout en base de donnees
			$entityManager->persist($user);
			$entityManager->flush();

			return $this->redirectToRoute('app_login');

		}
		// on redirige vers la page de login
		return $this->render('ex01/register.html.twig', [
			'registrationForm' => $form->createView(),
		]);
	}


}