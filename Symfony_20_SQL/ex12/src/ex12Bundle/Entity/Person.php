<?php

namespace App\ex12Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\ex12Bundle\Repository\PersonRepository;

## on ajoute au dessus de chaque propriété les attributs doctrine pour définir le type de colonne

#[ORM\Entity(repositoryClass: PersonRepository::class)] #[ORM\Table(name: 'ex12_persons')]
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

	#[ORM\OneToOne(targetEntity: Address::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'address_id', referencedColumnName: 'id', nullable: true)]
    #[Assert\Valid]
    private $address;

	#[ORM\OneToOne(targetEntity: BankAccount::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'bank_account_id', referencedColumnName: 'id', nullable: true)]
    #[Assert\Valid]
    private $bankAccount;

	public function __construct() {}

	## GETTERS
	function getId() { return $this->id; }
	function getUsername() { return $this->username; }
	function getName() { return $this->name; }
	function getEmail() { return $this->email; }
	function getPhone() { return $this->phone; }
	function getEnable() { return $this->enable; }
	function getBirthdate() { return $this->birthdate; }
	function getAddress(): ?Address { return $this->address; }
	function getBankAccount(): ?BankAccount { return $this->bankAccount; }

	## SETTERS
	function setId($new_id) { $this->id = $new_id; }
	function setUsername($new_username) { $this->username = $new_username; }
	function setName($new_name) { $this->name = $new_name; }
	function setEmail($new_email) { $this->email = $new_email; }
	function setPhone($phone) { $this->phone = $phone; }
	function setEnable($new_enable) { $this->enable = $new_enable; }
	function setBirthdate($new_birthdate) { $this->birthdate = $new_birthdate; }

	public function setAddress(?Address $address): self { 
        $this->address = $address; 
        return $this; 
    }

	public function setBankAccount(?BankAccount $bankAccount): self { 
        $this->bankAccount = $bankAccount; 
        return $this; 
    }
}