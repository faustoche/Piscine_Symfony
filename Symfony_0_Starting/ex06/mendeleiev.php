<?php

function mendeleiev() {

	$file_content = file_get_contents("ex06.txt");
	$mendeleiev_tab = explode("\n", $file_content);
	$html_result = "
		<!DOCTYPE html>
		<html>

		\t<head>
			\t<title>Mendeleiev's table</title>
		\t</head>

		\t<body style=\"background-color: rgb(36, 34, 34); color: white; \">";

	$html_result .= "\n\t\t<table>";
	$current_col = 0;

	foreach($mendeleiev_tab as $all_elements) {

		## On vérifie que la liste n'est pas vide
		if (empty($all_elements))
			continue;

		## On récupère chaque élément individuellement donc on aura besoin
		$elements = explode(" =", $all_elements);
		$properties = explode(", ", $elements[1]);
		$position = explode(":", $properties[0]);
		$number = explode(":", $properties[1]);
		$symbol = explode(":", $properties[2]);
		$weight = explode(":", $properties[3]);
		$electron = explode(":", $properties[4]);

		## Début de la rendition html
		if ($position[1] == 0) {
			if ($html_result != "<table>")
				$html_result .= "\n\t\t</tr>\n";
			$html_result .= "\n\t\t<tr>\n";
			$current_col = 0;
		}

		$empty_case = $position[1] - $current_col;
		if ($empty_case > 0)
			$html_result .= str_repeat("\t\t\t<td></td>\n", $empty_case);
		$html_result .= "\t\t\t<td style=\"border: 1px solid #94206dff; padding:30px; box-shadow: 0 0 15px #ff00aa; font-size: 0.8rm;\">\n";
		$html_result .= "\t\t\t\t<h4 style=\"text-align: center; color: #ff00aa\">" . $elements[0] . "</h4>\n";
		$html_result .= "\t\t\t\t<ul style=\"padding-left: 0; margin: 0;\">\n";
		$html_result .= "\t\t\t\t\t<li>" . "Number: " . $number[1] . "</li>\n";
		$html_result .= "\t\t\t\t\t<li>" . "Weight: " . $weight[1] . "</li>\n";
		$html_result .= "\t\t\t\t\t<li>" . "Symbol: " . $symbol[1] . "</li>\n";
		$html_result .= "\t\t\t\t\t<li>" . "Electrons: " . $electron[1] . "</li>\n";
		$html_result .= "\t\t\t\t</ul>\n";
		$html_result .= "\t\t\t</td>\n";

		$current_col = $position[1] + 1;
	}

	$html_result .= "\n\t\t</tr>\n";
	$html_result .= "\n\t\t</table>\n\t</body>\n</html>";

	file_put_contents("mendeleiev.html", $html_result);
}

mendeleiev();


?>