<?php

namespace App\e09Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Asserts;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

## on ajoute au dessus de chaque propriété les attributs doctrine pour définir le type de colonne

#[ORM\Entity] #[ORM\Table(name: 'persons')]
class Person {

	#[ORM\Id] #[ORM\GeneratedValue] #[ORM\Column(type: 'integer')]
	private $id;

	#[ORM\Column(type: 'string', unique: true)]
	#[Assert\NotBlank(message: "Username cannot be empty")]
	private $username;

	#[ORM\Column(type: 'string', unique: true)]
	#[Assert\NotBlank]
	private $name;

	#[ORM\Column(type: 'string', unique: true)]
	#[Assert\NotBlank]
	#[Assert\Email(message: "The email {{ value }} is not a valid email")]
	private $email;

	#[ORM\Column(type: 'string', nullable: true)]
	private $phone;

	#[ORM\Column(type: 'boolean')]
	private $enable;

	#[ORM\Column(type: 'datetime', nullable: true)]
	private $birthdate;

	#[ORM\OneToMany(mappedBy: 'person', targetEntity: Address::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
	private $addresses;

	#[ORM\OneToMany(mappedBy: 'person', targetEntity: BankAccount::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
	private $bankAccounts;

	public function __construct() {
        $this->addresses = new ArrayCollection();
        $this->bankAccounts = new ArrayCollection();
    }

	## GETTERS
	function getId() { return $this->id; }
	function getUsername() { return $this->username; }
	function getName() { return $this->name; }
	function getEmail() { return $this->email; }
	function getPhone() { return $this->phone; }
	function getEnable() { return $this->enable; }
	function getBirthdate() { return $this->birthdate; }
	function getAddresses(): Collection { return $this->addresses; }
	function getBankAccounts(): Collection { return $this->bankAccounts; }

	## SETTERS
	function setId($new_id) { $this->id = $new_id; }
	function setUsername($new_username) { $this->username = $new_username; }
	function setName($new_name) { $this->name = $new_name; }
	function setEmail($new_email) { $this->email = $new_email; }
	function setPhone($phone) { $this->phone = $phone; }
	function setEnable($new_enable) { $this->enable = $new_enable; }
	function setBirthdate($new_birthdate) { $this->birthdate = $new_birthdate; }

	public function addAddress(Address $address): self {
		if (!$this->addresses->contains($address)) {
			$this->addresses[] = $address;
			$address->setPerson($this);
		}
		return $this;
	}

	public function removeAddress(Address $address): self {
		if ($this->addresses->removeElement($address)) {
			if ($address->getPerson() === $this) {
				$address->setPerson(null);
			}
		}
		return $this;
	}

	public function addBankAccount(BankAccount $bankAccount): self {
		if (!$this->bankAccounts->contains($bankAccount)) {
			$this->bankAccounts[] = $bankAccount;
			$bankAccount->setPerson($this);
		}
		return $this;
	}

	public function removeBankAccount(BankAccount $bankAccount): self {
		if ($this->bankAccounts->removeElement($bankAccount)) {
			if ($bankAccount->getPerson() === $this) {
				$bankAccount->setPerson(null);
			}
		}
		return $this;
	}
}