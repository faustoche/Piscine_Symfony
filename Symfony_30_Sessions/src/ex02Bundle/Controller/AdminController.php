<?php

namespace App\ex02Bundle\Controller;

use App\ex01Bundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

// on cree une route admin et seulement ceux avec le role admin peuvent y acceder!
#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]

class AdminController extends AbstractController
{
	#[Route('/', name: 'app_admin_index')]
	public function index(EntityManagerInterface $entity): Response
	{
		$users = $entity->getRepository(User::class)->findAll();
		return $this->render('ex02/admin.html.twig', [
			'users' => $users,
		]);
	}

	#[Route('/user/{id}/delete', name: 'app_admin_delete_user')]
	public function deleteUser(User $user, EntityManagerInterface $entity): Response
	{
		// protection pour ne pas qu'on se supprime soi meme
		if ($user === $this->getUser()) {
			$this->addFlash('error', 'You cannot delete yourself!');
			return $this->redirectToRoute('app_admin_index');
		}

		$entity->remove($user);
		$entity->flush();

		$this->addFlash('success', 'User deleted successfully!');
		return $this->redirectToRoute('app_admin_index');
		
	}
}