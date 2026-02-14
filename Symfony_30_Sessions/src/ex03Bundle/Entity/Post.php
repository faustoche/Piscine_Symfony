<?php

namespace App\ex03Bundle\Entity;

use App\ex01Bundle\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\ex05Bundle\Entity\Vote;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'app_post')]
class Post 
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;
	
	#[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_date = null;

	// on pense a faire une relation avec le user de l'exo 1
	#[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

	#[ORM\OneToMany(mappedBy: 'post', targetEntity: Vote::class, cascade: ['remove'])]
    private Collection $votes;

	#[ORM\ManyToOne(targetEntity: User::class)]
    private ?User $last_editor = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $last_edit_date = null;

	public function __construct()
	{
		// initialisation de la date de creation auto
		$this->created_date = new \DateTime();
		$this->votes = new ArrayCollection(); // ajouter les votes ici
	}

	public function getId(): ?int { return $this->id; }
    public function getTitle(): ?string { return $this->title; }
    public function getContent(): ?string { return $this->content; }
    public function getCreatedDate(): ?\DateTimeInterface { return $this->created_date; }
    public function getAuthor(): ?User { return $this->author; }
	public function getLastEditor(): ?User { return $this->last_editor; }
    public function getLastEditDate(): ?\DateTimeInterface { return $this->last_edit_date; }
    
	public function setLastEditor(?User $last_editor): self { $this->last_editor = $last_editor; return $this; }
    public function setLastEditDate(?\DateTimeInterface $last_edit_date): self { $this->last_edit_date = $last_edit_date; return $this; }
    public function setTitle(string $title): self { $this->title = $title; return $this; }
    public function setContent(string $content): self { $this->content = $content; return $this; }
    public function setCreatedDate(\DateTimeInterface $created_date): self { $this->created_date = $created_date; return $this; }
    public function setAuthor(?User $author): self { $this->author = $author; return $this; }

	/**
     * @return Collection<int, Vote>
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    // helpers pour compter
    public function getLikesCount(): int {
        $count = 0;
        foreach ($this->votes as $vote) {
            if ($vote->getValue() > 0) $count++;
        }
        return $count;
    }

    public function getDislikesCount(): int {
        $count = 0;
        foreach ($this->votes as $vote) {
            if ($vote->getValue() < 0) $count++;
        }
        return $count;
    }
}