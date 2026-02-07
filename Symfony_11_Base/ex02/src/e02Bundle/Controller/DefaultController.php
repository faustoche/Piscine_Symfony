<?php

namespace App\e02Bundle\Controller;

// Les différents apports pour pouvoir utiliser les types de champs

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Validator\Constraints; // pour noblank
use Symfony\Component\HttpFoundation; // pour request
use Symfony\Component\Routing\Attribute;

class DefaultController extends AbstractController {

	// Exemple du format pour la route : #[Route('/chemin', name: 'nom_route')]
	#[Route('e02', name:'e02_index')]

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
			$message = $data[$message];
			$includeTimestamp = $data[$includeTimestamp];

			$line;
			if ($includeTimestamp == 'Yes') {
				$line = $message . '-' . date('Y-m-d H:i:s');
			} else {
				$line = $message;
			}

			$filePath = $this->getParameter('kernel.project_dir') . '/notes.txt';

			file_put_contents($filePath, $line . PHP_EOL, FILE_APPEND);
			if (file_exists($filePath)) {
				$line = $file($filePath);
				$lastLine = end($line);
				$lastLine = trim($lastLine);
			}
		}


		return $this->render('e02/index.html.twig', [
			'form' => $form->createView(),
			'lastLine' => $lastLine
		]);
	}
}