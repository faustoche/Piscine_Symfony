<?php

class TemplateEngineClass {

	private ElemClass $element;

	function __construct(ElemClass $elem) {
		$this->element = $elem;
	}

	function createFile($fileName) {

		$file_content = $this->element -> getHTML();
			
		#on rend ça dans un fichier nommé en paramètre
		file_put_contents($fileName, $file_content);
	}
}

?>