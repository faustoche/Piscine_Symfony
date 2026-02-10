<?php

class TemplateEngine {

	function createFile(HotBeverage $hot_beverage) {

		$file_content = file_get_contents("./template.html");
		$reflection = new Reflection($hot_beverage);

		# il faut utiliser ca sur l'objet reflection
		$className = $reflection -> getShortName();
		$properties = $reflection -> getProperties();

		foreach ($properties as $property) {
			$propertyName = $property -> getName();
			$methodName = 'get' .ucfirst($propertyName);

			if (method_exists($hot_beverage, $methodName)) {
				## appel dynamique on execute la methode sur l'objet origin
				$value = $hot_beverage->$methodName();
				$file_content = str_replace('{' . $propertyName . '}', $value, $file_content);
			}
		}
		file_put_contents($className . ".html", $file_content);

	}
}

?>