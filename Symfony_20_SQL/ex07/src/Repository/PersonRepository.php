<?php

namespace App\ex07Bundle\Repository;

use App\ex07Bundle\Entity\Person;
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

    public function update(): void {
        $this->getEntityManager()->flush();
    }
}