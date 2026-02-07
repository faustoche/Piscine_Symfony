<?php

namespace e02Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

	## trouver un autre nom celui ci est pas très clair
	public function indexAction() {
		## on pointe vers le template
		return $this->render('e02/index.html.twig');
	}
}