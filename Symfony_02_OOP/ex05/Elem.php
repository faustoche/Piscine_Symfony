<?php

include ('./MyException.php');

class ElemClass {
	private $element;
	private $content;
	private $children = [];
	private $attributes = [];
	private $validBeacons = [
		'html', 'head', 'body', 'title', 'meta', 'img', 'hr', 'br', 
		'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 
		'p', 'span', 'div', 
		'table', 'tr', 'th', 'td', 'ul', 'ol', 'li'
	];
	
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

	function validPage() {
		switch ($this->element) {
			case 'html';
				if (count($this->children) != 2)
					return false;
				if ($this->children[0]->element != 'head' || $this->children[1]->element != 'body')
					return false;
				break;
			case 'head';
				$nb_title = 0; $nb_meta = 0;
				foreach($this->children as $child) {
					if ($child->element == 'title')
						$nb_title += 1;
					if ($child->element == 'meta')
						$nb_meta += 1;
				}
				if ($nb_title != 1 || $nb_meta != 1)
					return false;
				break;
			case 'table';
				foreach($this->children as $child) {
					if ($child->element != 'tr')
						return false;
				}
				break;
			case 'tr';
				foreach($this->children as $child) {
					if ($child->element != 'th' && $child->element != 'td')
						return false;
				}
				break;
			case 'ul'; case 'ol';
				foreach($this->children as $child) {
					if ($child->element != 'li')
						return false;
				}
				break;
			case 'p';
				if (count($this->children) != 0)
					return false;
				break;
			default:
				break;
		}

		foreach($this->children as $child) {
			if ($child->validPage() == false)
				return false;
		}

		return true;
	}
}


?>