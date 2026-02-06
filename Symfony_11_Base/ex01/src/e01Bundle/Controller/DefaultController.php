<?php
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

## on hérite abstractController qui va nous permettre d'appeler this->render() 
## this->rneder() va permettre l'affichage de la page html (via twig)
class DefaultController extends AbstractController {

    ## ajouter une route principale + 1 route pour les articles
    ## la route principale va accepter des options
    ## article est la variable qui va capturer tout ce qu'il y a au dela de e01
    ## default: si l'user ecrit e01 seul, on considere que article = main
    #[Route('/e01/{article}', name: 'homepage', defaults: ['article' => 'main'])]

    function showPage(string $article) {
        return $this->render('e01.html.twig');
    }
}