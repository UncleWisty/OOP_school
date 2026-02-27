<?php

declare(strict_types=1);

namespace App\Domain\Student;

use App\Domain\Shared\DomainException;

final class StudentId
{
    public function __construct(private string $value)
    {
        $this->ensureIsValid($value);
    }

    private function ensureIsValid(string $value): void
    {
        if (empty($value)) {
            throw new DomainException('StudentId cannot be empty');
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value();
    }
}