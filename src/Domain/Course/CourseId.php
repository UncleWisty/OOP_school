<?php

declare(strict_types=1);

namespace App\Domain\Course;

use App\Domain\Shared\DomainException;

final class CourseId
{
    public function __construct(private string $value)
    {
        if (empty($value)) {
            throw new DomainException('CourseId cannot be empty');
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}