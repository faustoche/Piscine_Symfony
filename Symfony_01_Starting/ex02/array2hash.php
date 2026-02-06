<?php

function array2hash($tab){

	## On créé 2 tableaux pour pouvoir stocker les données
	$result = array();
	$temp = array();

	##
	foreach ($tab as $temp) {
		$result[$temp['age']] = $temp['name'];
	}
	return $result;
}

########### TEST02.PHP ###########

// include('./array2hash.php');
// $array = array(array("name" => "Pierre", "age" => "30"), array("name" => "Mary", "age" => "28"));
// print_r ( array2hash($array) );


?>


