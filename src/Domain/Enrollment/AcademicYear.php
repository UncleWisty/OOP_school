<?php

declare(strict_types=1);

namespace App\Domain\Enrollment;

use App\Domain\Shared\DomainException;

final class AcademicYear
{
    public function __construct(
        private int $startYear,
        private int $endYear
    ) {
        $this->ensureIsValid($startYear, $endYear);
    }

    private function ensureIsValid(int $start, int $end): void
    {
        if ($start >= $end) {
            throw new DomainException('Start year must be less than end year');
        }
    }

    public function value(): string
    {
        return sprintf('%d/%d', $this->startYear, $this->endYear);
    }

    public function equals(self $other): bool
    {
        return $this->value() === $other->value();
    }
}