<?php

declare(strict_types=1);

namespace App\Domain\Student;

use App\Domain\Enrollment\Enrollment;
use App\Domain\Enrollment\AcademicYear;
use App\Domain\Shared\DomainException;

final class Student
{
    private array $enrollments = [];

    public function __construct(
        private StudentId $id,
        private Email $email
    ) {}

    public function id(): StudentId
    {
        return $this->id;
    }

    public function email(): Email
    {
        return $this->email;
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