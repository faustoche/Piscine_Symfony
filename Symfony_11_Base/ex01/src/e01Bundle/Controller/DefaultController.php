<?php

namespace App\e01Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

## on hérite abstractController qui va nous permettre d'appeler this->render() 
## this->rneder() va permettre l'affichage de la page html (via twig)
class DefaultController extends AbstractController {

    ## ajouter une route principale + 1 route pour les articles
    ## la route principale va accepter des options
    ## article est la variable qui va capturer tout ce qu'il y a au dela de e01
    ## default: si l'user ecrit e01 seul, on considere que article = main
    #[Route('/e01/{article}', name: 'homepage', defaults: ['article' => 'main'])]

    function showPage(string $article) {

        $articlePage = [ 
            'gull' => '<h1>Les Mouettes</h1><p>Les mouettes sont des oiseaux...</p>',
            'bear' => '<h1>Les Ours</h1><p>Les ours sont des mammifères...</p>',
            'dog' => '<h1>Les Chiens</h1><p>Les chiens sont des ...</p>'
        ];

        $contentPage = '
            <h1>Page d\'accueil</h1>
            <ul>
                <li><a href="/e01/gull">Les mouettes</a></li>
                <li><a href="/e01/bear">Les ours</a></li>
                <li><a href="/e01/dog">Les chiens</a></li>
            </ul>
        ';

        if (array_key_exists($article, $articlePage)) {
            $contentPage = $articlePage[$article];
        }

        return $this->render('e01/e01.html.twig', [
            'content' => $contentPage
        ]);
    }
}