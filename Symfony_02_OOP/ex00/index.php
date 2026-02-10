<?php

include('./TemplateEngine.php');

$parameters = array( "nom" => "Barbapapa", "auteur" => "Faustine", "description" => "Des bestioles qui peuvent prendre la forme qu'elles veulent", "prix" => "16" );

$template = new TemplateEngine();

$template -> createFile("text.html", "book_description.html", $parameters);

?>