<?php

namespace App\ex09Bundle\Repository;

use App\ex09Bundle\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PersonRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Person::class);
    }

    public function save(Person $person): void {
        $this->getEntityManager()->persist($person);
        $this->getEntityManager()->flush();
    }

    public function remove(Person $person): void {
        $this->getEntityManager()->remove($person);
        $this->getEntityManager()->flush();
    }
}