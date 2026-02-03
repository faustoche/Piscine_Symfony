<?php

class TextClass {
	
	public $strings;
	
	function __construct($strings) {
		$this->strings = $strings;
	}

	function append($new_string) {
		# should add new string to the class
		array_push($this->strings, $new_string);
	}

	function readData() {
		# return all the string in HTML. Each chain should be in <p>
		$html_result = "";
		
		foreach ($this->strings as $string) {
			$html_result .= "<p>" . $string . "</p>\n";
		}
		return $html_result;
	}
}

?>