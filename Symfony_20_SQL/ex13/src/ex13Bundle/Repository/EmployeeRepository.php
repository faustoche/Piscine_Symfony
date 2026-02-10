<?php
namespace App\ex13Bundle\Repository;

use App\ex13Bundle\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EmployeeRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Employee::class);
    }
    public function save(Employee $employee): void {
        $this->getEntityManager()->persist($employee);
        $this->getEntityManager()->flush();
    }
    public function remove(Employee $employee): void {
        $this->getEntityManager()->remove($employee);
        $this->getEntityManager()->flush();
    }
}