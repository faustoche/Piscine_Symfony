<?php

include('./Elem.php');
include('./TemplateEngine.php');

### ajouter des instances elements pour chaque partie de mon html

$html = new ElemClass('html');
$body = new ElemClass('body');
$title = new ElemClass('h1', 'I hate this exercice');
$phrase = new ElemClass('p', 'Really, I\'m not a fan of this exercice');
$image = new ElemClass('img');
$div = new ElemClass('div');
$span = new ElemClass('span', 'This is another text');

## on push les elements dans les parties necessaire

$div->pushElement($span);
$body->pushElement($title);
$body->pushElement($phrase);
$body->pushElement($div);
$body->pushElement($image);
$html->pushElement($body);

## comme sur les autres exos on crée le template et le fichier
$template = new TemplateEngineClass($html);
$template->createFile("ex03.html");

?>