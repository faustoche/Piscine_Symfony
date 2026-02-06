<?php

function array2hash($tab){

	$result = array();
	$temp = array();

	foreach ($tab as $temp) {
		$result[$temp['name']] = $temp['age'];
	}

	krsort($result);
	return $result;
}



// include('./array2hash_sorted.php');

// $array = array(array("name" => "Alice", "age" => "30"), array("name" => "Bob", "age" => "28"), array("name" => "Charly", "age" => "24"));
// print_r ( array2hash($array) );


?>