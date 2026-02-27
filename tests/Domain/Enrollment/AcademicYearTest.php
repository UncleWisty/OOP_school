<?php

declare(strict_types=1);

namespace Tests\Domain\Enrollment;

use PHPUnit\Framework\TestCase;
use App\Domain\Enrollment\AcademicYear;
use App\Domain\Shared\DomainException;

final class AcademicYearTest extends TestCase
{
    public function test_valid_academic_year_can_be_created(): void
    {
        $year = new AcademicYear(2024, 2025);
        $this->assertInstanceOf(AcademicYear::class, $year);
    }

    public function test_invalid_academic_year_throws_exception(): void
    {
        $this->expectException(DomainException::class);
        new AcademicYear(2025, 2024);
    }

    public function test_two_academic_years_with_same_values_are_equal(): void
    {
        $a = new AcademicYear(2024, 2025);
        $b = new AcademicYear(2024, 2025);
        $this->assertTrue($a->equals($b));
    }

    public function test_value_format_is_correct(): void
    {
        $year = new AcademicYear(2024, 2025);
        $this->assertSame('2024/2025', $year->value());
    }

    public function test_different_academic_years_are_not_equal(): void
    {
        $a = new AcademicYear(2023, 2024);
        $b = new AcademicYear(2024, 2025);
        $this->assertFalse($a->equals($b));
    }
}