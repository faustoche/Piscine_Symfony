<?php

namespace App\e13Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'employees')]
class Employee {

    // On défini les énums
    const POSITIONS = [
        'manager', 'account_manager', 'qa_manager', 'dev_manager',
        'ceo', 'coo', 'backend_dev', 'frontend_dev', 'qa_tester'
    ];
    
    const HOURS = [8, 6, 4];

    #[ORM\Id] #[ORM\GeneratedValue] #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    private $firstname;

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    private $lastname;

    #[ORM\Column(type: 'string', unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email(message: "'{{ value }}' is not a valid email")]
    private $email;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank]
    private $birthdate;

    #[ORM\Column(type: 'boolean')]
    private $active = true;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank]
    private $employedSince;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $employedUntil;

    #[ORM\Column(type: 'integer')]
    #[Assert\Choice(choices: self::HOURS, message: "Choose 4, 6 or 8 hours.")]
    private $hours;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank]
    #[Assert\Positive(message: "Salary has to be positive")]
    private $salary;

    #[ORM\Column(type: 'string')]
    #[Assert\Choice(choices: self::POSITIONS, message: "Invalid position.")]
    private $position;

    // RELATIONS!! 

	// Big boss of the employee -> many employees have one manager
    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'subordinates')]
    #[ORM\JoinColumn(name: 'manager_id', referencedColumnName: 'id', nullable: true)]
    private $manager;

	// Subordinates have one manage
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'manager')]
    private $subordinates;

    public function __construct() {
        $this->subordinates = new ArrayCollection();
    }

    public function __toString() {
        return $this->firstname . ' ' . $this->lastname . ' (' . $this->position . ')';
    }

    // GETTERS ET SETTERS
    
    public function getId() { return $this->id; }
    public function getFirstname() { return $this->firstname; }
    public function getLastname() { return $this->lastname; }
    public function getEmail() { return $this->email; }
    public function getBirthdate() { return $this->birthdate; }
    public function getActive() { return $this->active; }
    public function getEmployedSince() { return $this->employedSince; }
    public function getEmployedUntil() { return $this->employedUntil; }
    public function getHours() { return $this->hours; }
    public function getSalary() { return $this->salary; }
    public function getPosition() { return $this->position; }
    public function getManager(): ?self { return $this->manager; }
    public function getSubordinates(): Collection { return $this->subordinates; }
    
    public function setFirstname($v) { $this->firstname = $v; return $this; }
    public function setLastname($v) { $this->lastname = $v; return $this; }
	public function setEmail($v) { $this->email = $v; return $this; }
    public function setBirthdate($v) { $this->birthdate = $v; return $this; }
    public function setActive($v) { $this->active = $v; return $this; }
    public function setEmployedSince($v) { $this->employedSince = $v; return $this; }
    public function setEmployedUntil($v) { $this->employedUntil = $v; return $this; }
    public function setHours($v) { $this->hours = $v; return $this; }
    public function setSalary($v) { $this->salary = $v; return $this; }
    public function setPosition($v) { $this->position = $v; return $this; }
    public function setManager(?self $manager): self { $this->manager = $manager; return $this; }
}