<?php

include('./Elem.php');
include('./TemplateEngine.php');

### ajouter des instances elements pour chaque partie de mon html

$html = new Elem('html');
$body = new Elem('body');
$title = new Elem('h1', 'I hate this exercice');
$phrase = new Elem('p', 'Really, I\'m not a fan of this exercice');
$image = new Elem('img');
$div = new Elem('div');
$span = new Elem('span', 'This is another text');

## on push les elements dans les parties necessaire

$div->pushElement($span);
$body->pushElement($title);
$body->pushElement($phrase);
$body->pushElement($div);
$body->pushElement($image);
$html->pushElement($body);

## comme sur les autres exos on crée le template et le fichier
$template = new TemplateEngine($html);
$template->createFile("ex03.html");

?>