<?php

include('./Elem.php');
include('./TemplateEngine.php');

##### TEST VALIDE #####

echo "\033[1mTest de structure valide\033[0m" . "\n";

$html = new Elem('html');
$head = new Elem('head');
$body = new Elem('body');
$title = new Elem('title', 'Bonjour');
$meta = new Elem('meta', null, ['charset' => 'utf-8']);
$div = new Elem('div');
$p = new Elem('p', 'I love Esnupi');

$head->pushElement($title);
$head->pushElement($meta);

$div->pushElement($p);
$body->pushElement($div);

$html->pushElement($head);
$html->pushElement($body);

echo "Résultat attendu: bool(true)" . "\n";
echo "Résultat obtenu : ";
var_dump($html->validPage());
echo "----------------------------------------" . "\n";

##### TEST INVALIDE - SANS HEAD #####

echo "\033[1mTest de structure invalide - sans head\033[0m" . "\n";

$html_bad = new Elem('html');
$body_bad = new Elem('body');

$html_bad->pushElement($body_bad);

echo "Résultat attendu: bool(false)" . "\n";
echo "Résultat obtenu : ";
var_dump($html_bad->validPage());
echo "----------------------------------------" . "\n";

##### TEST INVALIDE - MAUVAIS P #####

echo "\033[1mTest de structure invalide - mauvais p\033[0m" . "\n";

$p_bad = new Elem('p', 'I really love Snoopy');
$span_bad = new Elem('span', 'I shouldn\'t be there');

$p_bad->pushElement($span_bad);

echo "Résultat attendu: bool(false)" . "\n";
echo "Résultat obtenu : ";
var_dump($p_bad->validPage());
echo "----------------------------------------" . "\n";

?>