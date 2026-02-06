<?php

include ('./MyException.php');

class ElemClass {
	private $element;
	private $content;
	private $children = [];
	private $attributes = [];
	private $validBeacons = ['html', 'body', 'div', 'p', 'span', 'h1', 'img', 'table', 'tr', 'th', 'td', 'ul', 'ol', 'li'];

	## content = null pour le rendre optionnel
	function __construct(string $element, ?string $content = null, array $attributes = []) {
		$this->element = $element;
		$this->content = $content;
		$this->attributes = $attributes;

		if (!in_array($this->element, $this->validBeacons))
			throw new MyException('Undefined');
	}

	function pushElement(ElemClass $elem) {
		array_push($this->children, $elem);
	}

	function getHTML() {
		$orphans = array(
			'meta',
			'img',
			'hr',
			'br'
		);

		$html_content = '<' . $this->element;

		foreach ($this->attributes as $key => $value) {
			$html_content .= " " . $key . "=\"" . $value . "\"";
		}

		$html_content .= ">";

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