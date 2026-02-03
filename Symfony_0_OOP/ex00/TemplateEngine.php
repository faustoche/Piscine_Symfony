<?php

class TemplateEngineClass {

	public $fileName;
	public $templateName;
	public $parameters;


	function createFile($fileName, $templateName, $parameters) {

		# on récupère le contenu du templace
		$file_content = file_get_contents($templateName);

		#vérification si jamais il est vide
		if (empty($file_content))
			return (print("Model is empty\n"));

		# on boucle sur les paramètres pour récupérer clé/valeur
		foreach($parameters as $key => $value) {
			# on rajoute les accolades
			$key = "{" . $key . "}";
			# on remplace le contenu par la valeur de la clé
			$file_content = str_replace($key, $value, $file_content);
		}

		#on rend ça dans un fichier nommé en paramètre
		file_put_contents($fileName, $file_content);
	}
}

?>