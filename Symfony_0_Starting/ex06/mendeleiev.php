<?php

function mendeleiev() {

	$file_content = file_get_contents("ex06.txt");
	$mendeleiev_tab = explode("\n", $file_content);
	$html_result = "
		<!DOCTYPE html>
		<html>

		<head>
			<title>Mendeleiev's table</title>
		</head>

		<body style=\"background-color: rgb(36, 34, 34); color: white; \">";

	$html_result .= "<table>";
	$current_col = 0;

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
		if ($position[1] == 0) {
			if ($html_result != "<table>")
				$html_result .= "</tr>\n";
			$html_result .= "<tr>\n";
			$current_col = 0;
		}

		$empty_case = $position[1] - $current_col;
		if ($empty_case > 0)
			$html_result .= str_repeat("<td></td>", $empty_case);
		$html_result .= "<td style=\"border: 1px solid #94206dff; padding:10px; box-shadow: 0 0 15px #ff00aa;\" background>\n";
		$html_result .= "<h4 style=\"text-align: center; color: #ff00aa\">" . $elements[0] . "</h4>\n";
		$html_result .= "<ul>\n";
		$html_result .= "<li>" . $weight[1] . "</li>\n";
		$html_result .= "<li>" . $symbol[1] . "</li>\n";
		$html_result .= "</ul>\n";
		$html_result .= "</td>\n";

		$current_col = $position[1] + 1;
	}

	$html_result .= "</tr>\n";
	$html_result .= "</table>\n";

	file_put_contents("mendeleiev.html", $html_result);
}

mendeleiev();


?>