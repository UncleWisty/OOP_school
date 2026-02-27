<?php

declare(strict_types=1);

namespace App\Domain\Teacher;

use App\Domain\Subject\SubjectId;
use App\Domain\Shared\DomainException;

final class Teacher
{
    private array $subjects = [];

    public function __construct(
        private TeacherId $id,
        private string $name
    ) {}

    public function id(): TeacherId
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function subjects(): array
    {
        return $this->subjects;
    }

    public function assignSubject(SubjectId $subjectId): void
    {
        if ($this->teachesSubject($subjectId)) {
            throw new DomainException('Teacher is already assigned to this subject');
        }

        $this->subjects[] = $subjectId;
    }

    private function teachesSubject(SubjectId $subjectId): bool
    {
        foreach ($this->subjects as $assignedSubject) {
            if ($assignedSubject->value() === $subjectId->value()) {
                return true;
            }
        }
        
        return false;
    }
}