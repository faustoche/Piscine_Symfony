<?php

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

	foreach($array as $single_state) {
		if (isset($states[$single_state])) {
			$temp = $states[$single_state];
			if (isset($capitals[$temp])) {
				echo $capitals[$temp] . " is the capital of " . $single_state . "\n";
			}
		} else {
			echo $single_state . " is neither a capital nor a state" . "\n";
		}
	}
}

?>