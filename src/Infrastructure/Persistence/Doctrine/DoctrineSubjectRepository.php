<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Subject\Subject;
use App\Domain\Subject\SubjectId;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineSubjectRepository
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function find(SubjectId $id): ?Subject
    {
        return $this->em->find(Subject::class, $id->value());
    }

    public function findAll(): array
    {
        return $this->em->getRepository(Subject::class)->findAll();
    }

    public function save(Subject $subject): void
    {
        $this->em->persist($subject);
        $this->em->flush();
    }

    public function delete(Subject $subject): void
    {
        $this->em->remove($subject);
        $this->em->flush();
    }
}
