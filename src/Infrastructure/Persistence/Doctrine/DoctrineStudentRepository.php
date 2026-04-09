<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Student\Student;
use App\Domain\Student\StudentId;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineStudentRepository
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function find(StudentId $id): ?Student
    {
        return $this->em->find(Student::class, $id->value());
    }

    public function findAll(): array
    {
        return $this->em->getRepository(Student::class)->findAll();
    }

    public function save(Student $student): void
    {
        $this->em->persist($student);
        $this->em->flush();
    }

    public function delete(Student $student): void
    {
        $this->em->remove($student);
        $this->em->flush();
    }
}
