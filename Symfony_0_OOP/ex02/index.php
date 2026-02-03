<?php

include('./HotBeverage.php');
include('./Coffee.php');
include('./Tea.php');
include('./TemplateEngine.php');

$template = new TemplateEngineClass();

## Création de l'objet coffee?
$myCoffee = new CoffeeClass(
	"Un café latte vanille",  #description
	"Froid", #comment
	"Vanilla latte", #nom
	15, #price
	3 #resistance
);

## Création de l'objet tea
$myTea = new TeaClass(
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