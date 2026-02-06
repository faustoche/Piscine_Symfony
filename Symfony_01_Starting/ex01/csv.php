<?php

## On récupère le contenu du fichier
$filecontent = file_get_contents("ex01.txt");

## On applique explode pour découper le contenu à partir de notre séparateur
$output = explode(',', $filecontent);

## On parcours ce qui a été explode et on trim si jamais y a des espaces, etc
foreach ($output as $value) {
	echo trim($value) . "\n";
}

?>