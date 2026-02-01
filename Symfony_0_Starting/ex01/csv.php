<?php

$filecontent = file_get_contents("ex01.txt");
$output = str_replace(',', "\n", $filecontent);

echo $output;
?>