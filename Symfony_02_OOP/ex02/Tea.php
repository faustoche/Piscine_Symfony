<?php

class TeaClass extends HotBeverageClass {
	function __construct(private $description, private $comment, string $nom, float $price, int $resistance) {
		parent::__construct($nom, $price, $resistance);
	}

	function getDescription() {
		return $this->description;
	}

	function getComment() {
		return $this->comment;
	}
}

?>