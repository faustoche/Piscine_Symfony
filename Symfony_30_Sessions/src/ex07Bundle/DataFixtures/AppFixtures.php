<?php

namespace App\ex07Bundle\DataFixtures;

use App\ex01Bundle\Entity\User;
use App\ex03Bundle\Entity\Post;
use App\ex05Bundle\Entity\Vote;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $users = [];
        $profiles = [
            ['name' => 'admin', 'roles' => ['ROLE_ADMIN'], 'rep' => 100],
            ['name' => 'newbie', 'roles' => [], 'rep' => 0],   // peut uniquement poster
            ['name' => 'fan', 'roles' => [], 'rep' => 4],      // peut like
            ['name' => 'hater', 'roles' => [], 'rep' => 7],    // peut dislike
            ['name' => 'bigboss', 'roles' => [], 'rep' => 15],    // peut tout editer
        ];

        foreach ($profiles as $p) {
            $user = new User();
            $user->setUsername($p['name']);
            $user->setPassword($this->hasher->hashPassword($user, 'password123')); // mdp pas defaut
            $user->setRoles($p['roles']);
            $user->setReputation($p['rep']);
            
            $manager->persist($user);
            $users[] = $user; // memoire
        }

        // on cree 5 postes par user
        $posts = [];
        foreach ($users as $user) {
            for ($i = 1; $i <= 3; $i++) {
                $post = new Post();
                $post->setTitle('Post by ' . $user->getUsername() . ' #' . $i);
                $post->setContent("This is a automatic generated content. Not IA, I swear.\nSuper Vive Snoopy");
                $post->setAuthor($user);
                $post->setCreatedDate(new \DateTime());
                
                $manager->persist($post);
                $posts[] = $post;
            }
        }

        // on genere des votes et le big boss vote sur le premier post
        $vote = new Vote();
        $vote->setVoter($users[4]);
        $vote->setPost($posts[0]);
        $vote->setValue(1);
        $manager->persist($vote);
        $manager->flush();
    }
}
