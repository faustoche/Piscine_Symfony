<?php

namespace App\e03Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController {

	#[Route('/e03', name: 'e03_index')]
	

	// number of colors est egal a 50 
	// 

	function displayShades() {
		$parameters = $this->getParameter('e03.number_of_colors');
		$colors = [
			'Black',
			'Red',
			'Blue',
			'Green'
		];

		// ici on va stocker toutes les nuances
		$shades = [];

		// on fait une boucle dans les parametres pour passer sur le niveau d'intensité
		for ($i = 0; $i < $parameters; $i++) {

			// on divise le numero de la ligne par le nb de ligne - 1
			// mulitplication par 255
			// on oublie pas la conversion en nombre entier
			$intensity = (int)(($i / ($parameters - 1)) * 255);

			$shades[] = [
				'black' => "rgba(0, 0, 0, " . (1 - ($i / ($parameters - 1))) . ")",
				'red' => "rgb($intensity, 0, 0)",
				'blue' => "rgb(0, 0, $intensity)",
				'green' => "rgb(0, $intensity, 0)"
			];
		}

		return $this->render('e03/index.html.twig', [
			'shades' => $shades,
			'colors' => $colors
		]);
	}
}