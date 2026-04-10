<?php

declare(strict_types=1);

namespace App\Domain\Enrollment;

use App\Domain\Course\CourseId;
use App\Domain\Subject\SubjectId;
use App\Domain\Student\StudentId;
use App\Domain\Shared\DomainException;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;

#[Entity]
#[Table(name: 'enrollments')]
final class Enrollment
{
    #[Id]
    #[Column(type: 'string', length: 36)]
    private string $id;

    #[Column(type: 'string')]
    private string $academicYear;

    #[Column(type: 'string', length: 36)]
    private string $studentId;

    #[Column(type: 'string', length: 36, nullable: true)]
    private ?string $courseId = null;

    #[Column(type: 'json')]
    private array $subjectIds = [];

    private function __construct(
        EnrollmentId $id,
        StudentId $studentId,
        AcademicYear $academicYear,
        ?CourseId $courseId = null,
        array $subjectIds = []
    ) {
        $this->id = $id->value();
        $this->studentId = $studentId->value();
        $this->academicYear = $academicYear->value();
        $this->courseId = $courseId ? $courseId->value() : null;
        $this->subjectIds = $subjectIds;
    }

    public static function enrollFullCourse(
        EnrollmentId $id,
        AcademicYear $academicYear,
        CourseId $courseId,
        StudentId $studentId
    ): self {
        return new self($id, $studentId, $academicYear, $courseId);
    }

    public static function enrollPartial(
        EnrollmentId $id,
        AcademicYear $academicYear,
        array $subjectIds,
        StudentId $studentId
    ): self {
        if (empty($subjectIds)) {
            throw new DomainException('Partial enrollment must have at least one subject');
        }

        foreach ($subjectIds as $subjectId) {
            if (!$subjectId instanceof SubjectId) {
                throw new DomainException('Invalid subject instance');
            }
        }

        // Convert SubjectId objects to plain string ids for storage
        $subjectIdValues = array_map(fn(SubjectId $s) => $s->value(), $subjectIds);

        return new self($id, $studentId, $academicYear, null, $subjectIdValues);
    }

    public function id(): EnrollmentId
    {
        return new EnrollmentId($this->id);
    }

    public function academicYear(): AcademicYear
    {
        $parts = explode('/', $this->academicYear);
        return new AcademicYear((int)$parts[0], (int)$parts[1]);
    }

    public function isFullCourse(): bool
    {
        return $this->courseId !== null;
    }

    public function courseId(): ?CourseId
    {
        return $this->courseId ? new CourseId($this->courseId) : null;
    }

    public function subjectIds(): array
    {
        return $this->subjectIds;
    }

    public function studentId(): StudentId
    {
        return new StudentId($this->studentId);
    }
}