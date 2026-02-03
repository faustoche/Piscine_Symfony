<?php

class HotBeverageClass {
	function __construct(protected string $nom, protected float $price, protected int $resistance) {
		$this->nom = $nom;
		$this->price = $price;
		$this->resistance = $resistance;
	}

	function getNom() {
		return $this->nom;
	}

	function getPrice() {
		return $this->price;
	}

	function getResistance() {
		return $this->resistance;
	}
}

?>