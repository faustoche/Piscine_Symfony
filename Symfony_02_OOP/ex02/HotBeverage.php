<?php

class HotBeverage {
	function __construct(protected string $name, protected float $price, protected int $resistance) {
		$this->name = $name;
		$this->price = $price;
		$this->resistance = $resistance;
	}

	function getName() {
		return $this->name;
	}

	function getPrice() {
		return $this->price;
	}

	function getResistance() {
		return $this->resistance;
	}
}

?>