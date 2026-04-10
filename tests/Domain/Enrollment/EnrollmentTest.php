<?php

declare(strict_types=1);

namespace Tests\Domain\Enrollment;

use PHPUnit\Framework\TestCase;
use App\Domain\Enrollment\Enrollment;
use App\Domain\Enrollment\EnrollmentId;
use App\Domain\Enrollment\AcademicYear;
use App\Domain\Subject\SubjectId;
use App\Domain\Student\StudentId;
use App\Domain\Shared\DomainException;

final class EnrollmentTest extends TestCase
{
    public function test_partial_enrollment_saves_subjects_correctly(): void
    {
        $enrollment = Enrollment::enrollPartial(
            new EnrollmentId('enr-1'),
            new AcademicYear(2024, 2025),
            [new SubjectId('sub-1')],
            new StudentId('std-1')
        );

        $this->assertCount(1, $enrollment->subjectIds());
        $this->assertFalse($enrollment->isFullCourse());
    }

    public function test_partial_enrollment_cannot_be_empty(): void
    {
        $this->expectException(DomainException::class);
        
        Enrollment::enrollPartial(
            new EnrollmentId('enr-1'),
            new AcademicYear(2024, 2025),
            [],
            new StudentId('std-1')
        );
    }

    public function test_full_enrollment_contains_course_and_is_full(): void
    {
        $enrollment = Enrollment::enrollFullCourse(
            new EnrollmentId('enr-2'),
            new AcademicYear(2024, 2025),
            new \App\Domain\Course\CourseId('crs-1'),
            new StudentId('std-1')
        );

        $this->assertTrue($enrollment->isFullCourse());
        $this->assertSame('crs-1', $enrollment->courseId()->value());
        $this->assertSame('enr-2', $enrollment->id()->value());
        $this->assertInstanceOf(AcademicYear::class, $enrollment->academicYear());
    }

    public function test_partial_enrollment_rejects_invalid_subject_instances(): void
    {
        $this->expectException(DomainException::class);

        Enrollment::enrollPartial(
            new EnrollmentId('enr-3'),
            new AcademicYear(2024, 2025),
            ['not-a-subject'],
            new StudentId('std-1')
        );
    }

    public function test_partial_enrollment_allows_duplicate_subject_ids(): void
    {
        $enrollment = Enrollment::enrollPartial(
            new EnrollmentId('enr-4'),
            new AcademicYear(2024, 2025),
            [new SubjectId('sub-1'), new SubjectId('sub-1')],
            new StudentId('std-1')
        );

        $this->assertCount(2, $enrollment->subjectIds());
        $this->assertSame('sub-1', $enrollment->subjectIds()[0]->value());
        $this->assertSame('sub-1', $enrollment->subjectIds()[1]->value());
    }
}