<?php

declare(strict_types=1);

namespace App\Domain\Enrollment;

use App\Domain\Course\CourseId;
use App\Domain\Subject\SubjectId;
use App\Domain\Shared\DomainException;

final class Enrollment
{
    private function __construct(
        private EnrollmentId $id,
        private AcademicYear $academicYear,
        private ?CourseId $courseId = null,
        private array $subjectIds = []
    ) {}

    public static function enrollFullCourse(
        EnrollmentId $id,
        AcademicYear $academicYear,
        CourseId $courseId
    ): self {
        return new self($id, $academicYear, $courseId);
    }

    public static function enrollPartial(
        EnrollmentId $id,
        AcademicYear $academicYear,
        array $subjectIds
    ): self {
        if (empty($subjectIds)) {
            throw new DomainException('Partial enrollment must have at least one subject');
        }

        foreach ($subjectIds as $subjectId) {
            if (!$subjectId instanceof SubjectId) {
                throw new DomainException('Invalid subject instance');
            }
        }

        return new self($id, $academicYear, null, $subjectIds);
    }

    public function id(): EnrollmentId
    {
        return $this->id;
    }

    public function academicYear(): AcademicYear
    {
        return $this->academicYear;
    }

    public function isFullCourse(): bool
    {
        return $this->courseId !== null;
    }

    public function courseId(): ?CourseId
    {
        return $this->courseId;
    }

    public function subjectIds(): array
    {
        return $this->subjectIds;
    }
}