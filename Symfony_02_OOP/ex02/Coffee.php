<?php

class Coffee extends HotBeverage {
	function __construct(private $description, private $comment, string $name, float $price, int $resistance) {
		parent::__construct($name, $price, $resistance);
	}

	function getDescription() {
		return $this->description;
	}

	function getComment() {
		return $this->comment;
	}
}

?>