<?php

class Elem {
	private $element;
	private $content;
	private $children = [];

	## content = null pour le rendre optionnel
	function __construct(string $element, ?string $content = null) {
		$this->element = $element;
		$this->content = $content;
	}

	function pushElement(Elem $elem) {
		array_push($this->children, $elem);
	}

	function getHTML() {
		$orphans = array(
			'meta',
			'img',
			'hr',
			'br'
		);

		$html_content = '<' . $this->element . '>';

		## vérifier si le nom de l'objet est une balise orpheline
		if (in_array($this->element, $orphans)) {
			## Si oui, alors on retourne la balise ouvrante et on arrete
			return $html_content . "\n";
		} 
		
		if ($this->content != null) {
			$html_content .= $this->content;
		}
			
		foreach ($this->children as $child) {
			$html_content .= $child -> getHTML();
		}
		$html_content .= '</' . $this->element . '>' . "\n";
		return $html_content;
	}
}

?>