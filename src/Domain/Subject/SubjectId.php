<?php

declare(strict_types=1);

namespace App\Domain\Subject;

use App\Domain\Shared\DomainException;

final class SubjectId
{
    public function __construct(private string $value)
    {
        if (empty($value)) {
            throw new DomainException('SubjectId cannot be empty');
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}