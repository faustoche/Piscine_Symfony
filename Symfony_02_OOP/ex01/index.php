<?php

include('./TemplateEngine.php');
include('./Text.php');

# Creating array of sentences
$array = array(
	"Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
	"Sed ac ullamcorper tortor.",
	"Duis a nisi luctus, placerat purus non, interdum leo.",
);

# New objects
$my_strings = new Text($array);
$template = new TemplateEngine();

# Using append function to add new sentences 
$my_strings -> append("Chien et chat");
$my_strings -> append("Test1 et test2");

$template -> createFile("result.html", $my_strings);

?>