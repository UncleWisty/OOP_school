<?php

declare(strict_types=1);

namespace App\Domain\Enrollment;

use App\Domain\Shared\DomainException;

final class EnrollmentId
{
    public function __construct(private string $value)
    {
        if (empty($value)) {
            throw new DomainException('EnrollmentId cannot be empty');
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}