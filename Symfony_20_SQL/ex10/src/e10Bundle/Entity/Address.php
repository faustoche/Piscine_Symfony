<?php

namespace App\e10Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity] #[ORM\Table(name: 'address')]
class Address {

	#[ORM\Id] #[ORM\GeneratedValue] #[ORM\Column(type: 'integer')]
	private $id;

	#[ORM\Column(type: 'string')] #[Assert\NotBlank]
	private $street;

	#[ORM\Column(type: 'string')] #[Assert\NotBlank]
	private $city;

	#[ORM\Column(type: 'string')] #[Assert\NotBlank]
	private $zipcode;

	#[ORM\ManyToOne(targetEntity: Person::class, inversedBy: 'addresses')] #[ORM\JoinColumn(nullable: false)]
	private $person;

	public function getId() { return $this->id; }
	public function getStreet() { return $this->street; }
	public function getCity() { return $this->city; }
	public function getZipcode() { return $this->zipcode; }
	public function getPerson() { return $this->person; }
	
	public function setStreet($street) { $this->street = $street; return $this; }
	public function setCity($city) { $this->city = $city; return $this; }
	public function setZipcode($zipcode) { $this->zipcode = $zipcode; return $this; }
	public function setPerson(?Person $person) { $this->person = $person; return $this; }
}