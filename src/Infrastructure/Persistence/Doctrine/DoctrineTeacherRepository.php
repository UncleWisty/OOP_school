<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Teacher\Teacher;
use App\Domain\Teacher\TeacherId;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineTeacherRepository
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function find(TeacherId $id): ?Teacher
    {
        return $this->em->find(Teacher::class, $id->value());
    }

    public function findAll(): array
    {
        return $this->em->getRepository(Teacher::class)->findAll();
    }

    public function save(Teacher $teacher): void
    {
        $this->em->persist($teacher);
        $this->em->flush();
    }

    public function delete(Teacher $teacher): void
    {
        $this->em->remove($teacher);
        $this->em->flush();
    }
}
