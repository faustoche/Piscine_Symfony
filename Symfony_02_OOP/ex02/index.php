<?php

include('./HotBeverage.php');
include('./Coffee.php');
include('./Tea.php');
include('./TemplateEngine.php');

$template = new TemplateEngine();

## Création de l'objet coffee?
$myCoffee = new Coffee(
	"Un café latte vanille",  #description
	"Froid", #comment
	"Vanilla latte", #nom
	15, #price
	3 #resistance
);

## Création de l'objet tea
$myTea = new Tea(
	"Un thé noir puissant",  #description
	"Infusé", #comment
	"Earl Grey", #nom
	5, #price
	4 #resistance
);

## creation des objets
$template->createFile($myCoffee);
$template->createFile($myTea);

?>