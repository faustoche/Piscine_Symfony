<?php

namespace App\ex01Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity] #[ORM\Table(name: 'app_user')] // on indique que c'est une table SQL
class User implements UserInterface, PasswordAuthenticatedUserInterface {

	#[ORM\Id] #[ORM\GeneratedValue] #[ORM\Column(type: 'integer')]
	private $id;

	#[ORM\Column(type: 'string', unique: true)]
	private $username;

	#[ORM\Column(type: 'string')]
	private $password;

	#[ORM\Column(type: 'json')]
	private $roles = [];

	// on ajoute la reputation a notre user
	#[ORM\Column(type: 'integer', options: ['default' => 0])]
	private $reputation = 0;


	// GETTERS
	public function getId(): ?int { return $this->id; }
	public function getUserIdentifier(): string { return (string) $this->username; }
	public function getUsername(): ?string { return $this->username; }
	public function getPassword(): ?string { return $this->password; }
	public function getReputation(): ?int { return $this->reputation; }
	public function getRoles(): array { 
		return $this->roles;
		$roles[] = 'ROLE_USER';
		return array_unique($roles);
	}

	// SETTERS
	public function setId($new_id): self { 
		$this->id = $new_id;
		return $this; 
	}
	
	public function setUsername($new_username): self { 
        $this->username = $new_username; 
        return $this;
    }

    public function setPassword($new_password): self { 
        $this->password = $new_password; 
        return $this; 
    }

    public function setRoles(array $new_roles): self { 
        $this->roles = $new_roles; 
        return $this; 
    }

	public function setReputation(int $new_reputation): self { 
        $this->reputation = $new_reputation; 
        return $this; 
    }

	// METHODS
	public function eraseCredentials(): void {}
}
