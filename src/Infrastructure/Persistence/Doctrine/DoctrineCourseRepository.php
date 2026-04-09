<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Course\Course;
use App\Domain\Course\CourseId;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineCourseRepository
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function find(CourseId $id): ?Course
    {
        return $this->em->find(Course::class, $id->value());
    }

    public function findAll(): array
    {
        return $this->em->getRepository(Course::class)->findAll();
    }

    public function save(Course $course): void
    {
        $this->em->persist($course);
        $this->em->flush();
    }
}
