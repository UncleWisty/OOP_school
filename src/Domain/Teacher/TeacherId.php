<?php

declare(strict_types=1);

namespace App\Domain\Teacher;

use App\Domain\Shared\DomainException;

final class TeacherId
{
    public function __construct(private string $value)
    {
        if (empty($value)) {
            throw new DomainException('TeacherId cannot be empty');
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}