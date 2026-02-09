<?php

namespace App\e01Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\Routing\Attribute\Route;


class DefaultController extends AbstractController {

    #[Route('/e01', name:'e01_index', methods:['GET'])]

    public function indexAction() {
        return $this->render('index.html.twig');
    }

    #[Route('/e01/create-table', name:'e01_create_table', methods:['POST'])]

    public function createTable(KernelInterface $kernel) {
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput(['command' => 'doctrine:schema:update', '--force' => true]);
        $stream = fopen('php://temp', 'w+');
        $output = new StreamOutput($stream);

        $statusCode = $application->run($input, $output);

        ## on retourne en arriere pour lire ce que la commande a repondu
        rewind($stream);
        $display = stream_get_contents($stream);

		if ($statusCode == 0)
			$this->addFlash('success', 'Success!');
        else {
			$this->addFlash('error', 'Error: ' . trim($display));
        }

        return $this->redirectToRoute('e01_index');
    }
}