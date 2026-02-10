<?php

namespace App\e12Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'bank_account')]
class BankAccount {

	#[ORM\Id] #[ORM\GeneratedValue] #[ORM\Column(type: 'integer')]
	private $id;

	#[ORM\Column(type: 'string')] #[Assert\NotBlank]
	private $bankName;

	#[ORM\Column(type: 'string')] #[Assert\NotBlank]
	private $iban;

	public function getId() { return $this->id; }
	public function getBankName() { return $this->bankName; }
	public function getIban() { return $this->iban; }
	public function getPerson() { return $this->person; }

	public function setBankName($bankName) { $this->bankName = $bankName; return $this; }
	public function setIban($iban) { $this->iban = $iban; return $this; }
	public function setPerson(?Person $person) { $this->person = $person; return $this; }
}