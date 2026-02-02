<?php

function mendeleiev() {

	$file_content = file_get_contents("ex06.txt");
	$mendeleiev_tab = explode("\n", $file_content);
	$html_result = "<table>";

	foreach($mendeleiev_tab as $all_elements) {

		## On vérifie que la liste n'est pas vide
		if (empty($all_elements))
			continue;

		## On récupère chaque élément individuellement donc on aura besoin
		$elements = explode(" =", $all_elements);
		$properties = explode(", ", $elements[1]);
		$position = explode(":", $properties[0]);
		$symbol = explode(":", $properties[2]);
		$weight = explode(":", $properties[3]);

		## Début de la rendition html
		if ($position[1] == 0)
			$html_result .= "</tr><tr>";

		$html_result .= "<td>";
		$html_result .= "<h4>" . $elements[0] . "</h4>";
		$html_result .= "<ul>";
		$html_result .= "<li>" . $weight[1] . "</li>";
		$html_result .= "<li>" . $symbol[1] . "</li>";
		$html_result .= "</ul>";
		$html_result .= "</td>";
	}

	$html_result .= "</tr>";
	$html_result .= "</table>";

	file_put_contents("mendeleiev.html", $html_result);
}

mendeleiev();


?>