<?php

$filecontent = file_get_contents("ex01.txt");
$output = explode(',', $filecontent);

foreach ($output as $value) {
	echo trim($value) . "\n";
}

?>