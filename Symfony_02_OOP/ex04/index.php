<?php

include('./Elem.php');
include('./TemplateEngine.php');

### ajouter des instances elements pour chaque partie de mon html

try {
	$html = new ElemClass('html');
	$body = new ElemClass('body');
	$title = new ElemClass('h1', 'Bonjour');
	$phrase = new ElemClass('p', 'Voici une photo de Snoopy');

	## Teste d'un attribut sur cette phrase
	$phrase_attribut = new ElemClass('p', 'Voici une photo de Snoopy avec un attribut', ['style' => 'font-weight: bold;', 'id' => 'SNOOPY']);

	## On rajoute un attribut sur cette image -> src
	$image = new ElemClass('img', null, ['src' => 'https://static.wixstatic.com/media/449abe_7b15686b2118476da4a733a7861dd772~mv2.jpg/v1/fill/w_1080,h_1080,al_c,q_85,enc_avif,quality_auto/sn-color.jpg']);
	//$div = new ElemClass('nimportenawak');
	$div = new ElemClass('div');
	$span = new ElemClass('span', 'J\'adore Snoopy');
	
	## on push les elements dans les parties necessaire
	
	$div->pushElement($span);
	$body->pushElement($title);
	$body->pushElement($phrase);
	$body->pushElement($phrase_attribut);
	$body->pushElement($div);
	$body->pushElement($image);
	$html->pushElement($body);

	## comme sur les autres exos on crée le template et le fichier
	$template = new TemplateEngineClass($html);
	$template->createFile("ex03.html");

} catch (MyException $error) {
	echo $error->errorMessage();
}



?>