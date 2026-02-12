<?php

namespace App\ex02Bundle\Controller;

// Les différents apports pour pouvoir utiliser les types de champs

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\HttpFoundation\Request; // pour request
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController {

	// Exemple du format pour la route : #[Route('/chemin', name: 'nom_route')]
	#[Route('/ex02', name:'ex02_index')]

	public function indexAction(Request $request) {
		
		$form = $this->createFormBuilder()
			->add('message', TextType::class, ['constraints' => [new NotBlank(['message' => 'Message cannot be empty'])]])
			->add('include_timestamp', ChoiceType::class, ['choices' => ['Yes' => 'Yes', 'No' => 'No'], 'label' => 'Include timestamp'])
			->add('submit', SubmitType::class, ['label' => 'Send'])
			->getForm();

		$form->handleRequest($request);
		$lastLine = null; // on va verifier la dernier ligne du fichier si elle existe

		if ($form->isSubmitted() && $form->isValid()) {
			$data = $form->getData();
			$message = $data['message'];
			$includeTimestamp = $data['include_timestamp'];

			$line = '';
			if ($includeTimestamp == 'Yes') {
				$line = $message . '-' . date('Y-m-d H:i:s');
			} else {
				$line = $message;
			}

			$filePath = $this->getParameter('kernel.project_dir') . '/notes.txt';

			file_put_contents($filePath, $line . PHP_EOL, FILE_APPEND);
			if (file_exists($filePath)) {
				$lines = file($filePath);
				$lastLine = end($lines);
				$lastLine = trim($lastLine);
			}
		}


		return $this->render('ex02/index.html.twig', [
			'form' => $form->createView(),
			'lastLine' => $lastLine
		]);
	}
}