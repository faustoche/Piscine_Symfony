<?php

function capital_city_from($state_name) {

	$states = [
	'Oregon' => 'OR',
	'Alabama' => 'AL',
	'New Jersey' => 'NJ',
	'Colorado' => 'CO',
	];

	$capitals = [
	'OR' => 'Salem',
	'AL' => 'Montgomery',
	'NJ' => 'trenton',
	'KS' => 'Topeka',
	];

	$result;
	$temp;

	if (isset($states[$state_name])) {
		$temp = $states[$state_name];
	} else {
		return $result = "Unknown";
	}

	if (isset($capitals[$temp])) {
		$result = $capitals[$temp];
	} else {
		return $result = "Unknown";
	}

	return $result;
}


?>