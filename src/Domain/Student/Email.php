<?php

declare(strict_types=1);

namespace App\Domain\Student;

use App\Domain\Shared\DomainException;

final class Email
{
    public function __construct(private string $value)
    {
        $this->ensureIsValid($value);
    }

    private function ensureIsValid(string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new DomainException(sprintf('Invalid email: <%s>', $value));
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}