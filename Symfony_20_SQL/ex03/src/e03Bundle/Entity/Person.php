<?php

namespace App\e03Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

## on ajoute au dessus de chaque propriété les attributs doctrine pour définir le type de colonne

#[ORM\Entity] #[ORM\Table(name: 'persons')]
class Person {

    #[ORM\Id] #[ORM\GeneratedValue] #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', unique: true)]
    private $username;

    #[ORM\Column(type: 'string', unique: true)]
    private $name;

    #[ORM\Column(type: 'string', unique: true)]
    private $email;

    #[ORM\Column(type: 'boolean')]
    private $enable;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $birthdate;

    #[ORM\Column(type: 'text')]
    private $address;

    ## GETTERS
    function getId() { return $this->id; }
    function getUsername() { return $this->username; }
    function getName() { return $this->name; }
    function getEmail() { return $this->email; }
    function getEnable() { return $this->enable; }
    function getBirthdate() { return $this->birthdate; }
    function getAddress() { return $this->address; }

    ## SETTERS
    function setId($new_id) { $this->id = $new_id; }
    function setUsername($new_username) { $this->username = $new_username; }
    function setName($new_name) { $this->name = $new_name; }
    function setEmail($new_email) { $this->email = $new_email; }
    function setEnable($new_enable) { $this->enable = $new_enable; }
    function setBirthdate($new_birthdate) { $this->birthdate = $new_birthdate; }
    function setAddress($new_address) { $this->address = $new_address; }
}