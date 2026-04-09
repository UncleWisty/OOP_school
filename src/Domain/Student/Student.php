<?php

declare(strict_types=1);

namespace App\Domain\Student;

use App\Domain\Enrollment\Enrollment;
use App\Domain\Enrollment\AcademicYear;
use App\Domain\Shared\DomainException;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[Entity]
#[Table(name: 'students')]
final class Student
{
    #[Id]
    #[Column(type: 'string', length: 36)]
    private string $id;

    #[Column(type: 'string')]
    private string $email;

    #[Column(type: 'json')]
    private array $enrollments = [];

    public function __construct(
        StudentId $id,
        Email $email
    ) {
        $this->id = (string)$id->value();
        $this->email = $email->value();
    }

    public function id(): StudentId
    {
        return new StudentId($this->id);
    }

    public function email(): Email
    {
        return new Email($this->email);
    }

    public function enrollments(): array
    {
        return $this->enrollments;
    }

    public function enroll(Enrollment $enrollment): void
    {
        $this->ensureNoDuplicateEnrollment($enrollment->academicYear());
        
        $this->enrollments[] = $enrollment;
    }

    private function ensureNoDuplicateEnrollment(AcademicYear $year): void
    {
        foreach ($this->enrollments as $existing) {
            if ($existing->academicYear()->equals($year)) {
                throw new DomainException('Student already enrolled in this academic year');
            }
        }
    }
}