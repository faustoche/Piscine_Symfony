<?php

namespace App\ex12Bundle\Repository;

use App\ex12Bundle\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Person::class);
    }

    public function findByFilterAndSort(?string $filter, string $sort, string $order)
    {
        $qb = $this->createQueryBuilder('p')
			// equivalent sql left join / optimisation et trie
            ->leftJoin('p.address', 'a')
            ->addSelect('a');

        // filtrage dynamique
        if ($filter) {
            $qb->andWhere('p.name LIKE :filter OR p.username LIKE :filter')
               ->setParameter('filter', '%' . $filter . '%');
        }

        // on securise le tri
        $validSorts = ['id' => 'p.id', 'name' => 'p.name', 'city' => 'a.city'];
        $sortField = $validSorts[$sort] ?? 'p.id';
        $sortOrder = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';

        $qb->orderBy($sortField, $sortOrder);

        return $qb->getQuery()->getResult();
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