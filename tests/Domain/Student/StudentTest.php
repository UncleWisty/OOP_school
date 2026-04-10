<?php

declare(strict_types=1);

namespace Tests\Domain\Student;

use PHPUnit\Framework\TestCase;
use App\Domain\Student\Student;
use App\Domain\Student\StudentId;
use App\Domain\Student\Email;
use App\Domain\Enrollment\Enrollment;
use App\Domain\Enrollment\EnrollmentId;
use App\Domain\Enrollment\AcademicYear;
use App\Domain\Course\CourseId;
use App\Domain\Shared\DomainException;

final class StudentTest extends TestCase
{
    public function test_student_can_be_enrolled_successfully(): void
    {
        $student = new Student(new StudentId('std-1'), new Email('a@a.com'));
        $enrollment = Enrollment::enrollFullCourse(
            new EnrollmentId('enr-1'),
            new AcademicYear(2024, 2025),
            new CourseId('crs-1'),
            new StudentId('std-1')
        );

        $student->enroll($enrollment);

        $this->assertCount(1, $student->enrollments());
    }

    public function test_student_cannot_be_enrolled_twice_in_same_academic_year(): void
    {
        $student = new Student(new StudentId('std-1'), new Email('a@a.com'));
        $year = new AcademicYear(2024, 2025);
        
    $student->enroll(Enrollment::enrollFullCourse(new EnrollmentId('enr-1'), $year, new CourseId('crs-1'), new StudentId('std-1')));

    $this->expectException(DomainException::class);
    $student->enroll(Enrollment::enrollFullCourse(new EnrollmentId('enr-2'), $year, new CourseId('crs-2'), new StudentId('std-1')));
    }

    public function test_getters_return_expected_values(): void
    {
        $id = new StudentId('std-42');
        $email = new Email('foo@bar.com');
        $student = new Student($id, $email);

        $this->assertSame($id->value(), $student->id()->value());
        $this->assertSame($email->value(), $student->email()->value());
    }

    public function test_student_can_be_enrolled_in_multiple_academic_years(): void
    {
        $student = new Student(new StudentId('std-1'), new Email('a@a.com'));

    $student->enroll(Enrollment::enrollFullCourse(new EnrollmentId('enr-1'), new AcademicYear(2023, 2024), new CourseId('crs-1'), new StudentId('std-1')));
    $student->enroll(Enrollment::enrollFullCourse(new EnrollmentId('enr-2'), new AcademicYear(2024, 2025), new CourseId('crs-2'), new StudentId('std-1')));

        $this->assertCount(2, $student->enrollments());
        $this->assertInstanceOf(Enrollment::class, $student->enrollments()[0]);
        $this->assertInstanceOf(Enrollment::class, $student->enrollments()[1]);
    }
}