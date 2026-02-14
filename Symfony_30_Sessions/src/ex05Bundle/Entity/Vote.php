<?php

namespace App\ex05Bundle\Entity;

use App\ex01Bundle\Entity\User;
use App\ex03Bundle\Entity\Post;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'app_vote')]
#[ORM\UniqueConstraint(name: 'unique_vote_user_post', columns: ['voter_id', 'post_id'])] // un seul vote par user post
class Vote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $voter = null;

    #[ORM\ManyToOne(targetEntity: Post::class, inversedBy: 'votes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Post $post = null;

    #[ORM\Column(type: 'integer')]
    private $value; // +1 like  -1 dislike

    public function getId(): ?int { return $this->id; }
    public function getVoter(): ?User { return $this->voter; }
    public function getPost(): ?Post { return $this->post; }
    public function getValue(): int { return $this->value; }

    public function setVoter(?User $voter): self {
		$this->voter = $voter;
		return $this;
	}

    public function setPost(?Post $post): self {
		$this->post = $post;
		return $this;
	}

    public function setValue(int $value): self {
		$this->value = $value;
		return $this;
	}
}