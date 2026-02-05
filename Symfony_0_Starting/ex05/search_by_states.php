<?php

########## RECHERCHE D'ÉTAT EXCLUSIVEMENT ##########

// function search_by_states($states_name) {

// 	$states = [
// 	'Oregon' => 'OR',
// 	'Alabama' => 'AL',
// 	'New Jersey' => 'NJ',
// 	'Colorado' => 'CO',
// 	];

// 	$capitals = [
// 	'OR' => 'Salem',
// 	'AL' => 'Montgomery',
// 	'NJ' => 'trenton',
// 	'KS' => 'Topeka',
// 	];

// 	$array = explode(", ", $states_name);

// 	foreach($array as $single_state) {
// 		if (isset($states[$single_state])) {
// 			$temp = $states[$single_state];
// 			if (isset($capitals[$temp])) {
// 				echo $capitals[$temp] . " is the capital of " . $single_state . "\n";
// 			}
// 		} else {
// 			echo $single_state . " is neither a capital nor a state" . "\n";
// 		}
// 	}
// }

########## RECHERCHE D'ÉTAT ET DE CAPITALES ##########

function search_by_states($states_name) {

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

	$array = explode(", ", $states_name);

	## Using isset to check if an array as some keys
	foreach($array as $single_state) {
		if (isset($states[$single_state])) {
			$temp = $states[$single_state];
			if (isset($capitals[$temp])) {
				echo $capitals[$temp] . " is the capital of " . $single_state . "\n";
			} else {
				echo $single_state . " is neither a capital nor a state" . "\n";
			}
		} else if (($state_code = array_search($single_state, $capitals)) && ($real_state_name = array_search($state_code, $states))) {
			echo $single_state . " is the capital of " . $real_state_name . "\n";
		} else {
			echo $single_state . " is neither a capital nor a state" . "\n";
		}
	}
}


########### TEST 05 ##########

// include('./search_by_states.php');
// search_by_states("Oregon, trenton, Topeka, NewJersey");

?>