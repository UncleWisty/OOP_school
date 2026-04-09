<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Enrollment\Enrollment;
use App\Domain\Enrollment\EnrollmentId;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineEnrollmentRepository
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function find(EnrollmentId $id): ?Enrollment
    {
        return $this->em->find(Enrollment::class, $id->value());
    }

    public function findAll(): array
    {
        return $this->em->getRepository(Enrollment::class)->findAll();
    }

    public function save(Enrollment $enrollment): void
    {
        $this->em->persist($enrollment);
        $this->em->flush();
    }
}
