<?php

class TemplateEngineClass {

	public $fileName;
	public $text;


	function createFile($fileName, $text) {

		$file_content = "
		<!DOCTYPE html>
		<html>

		<head>
			<title>Sentences</title>
		</head>

		<body>\n";

		#vérification si jamais il est vide
		if (empty($text))
			return (print("No text given\n"));


		$file_content .= $text -> readData();

		$file_content .= "
			</body>
		</html>";
			
		#on rend ça dans un fichier nommé en paramètre
		file_put_contents($fileName, $file_content);
	}
}

?>