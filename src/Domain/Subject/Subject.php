<?php

declare(strict_types=1);

namespace App\Domain\Subject;

use App\Domain\Course\CourseId;

final class Subject
{
    public function __construct(
        private SubjectId $id,
        private string $name,
        private CourseId $courseId
    ) {}

    public function id(): SubjectId
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function courseId(): CourseId
    {
        return $this->courseId;
    }
}