<?php

declare(strict_types=1);

namespace App\Domain\Course;

final class Course
{
    public function __construct(
        private CourseId $id,
        private string $name
    ) {}

    public function id(): CourseId
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }
}