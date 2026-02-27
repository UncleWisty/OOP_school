<?php

declare(strict_types=1);

namespace Tests\Domain\Subject;

use PHPUnit\Framework\TestCase;
use App\Domain\Subject\Subject;
use App\Domain\Subject\SubjectId;
use App\Domain\Course\CourseId;
use App\Domain\Shared\DomainException;

final class SubjectTest extends TestCase
{
    public function test_subject_can_be_created_and_getters_work(): void
    {
        $id = new SubjectId('sub-7');
        $courseId = new CourseId('crs-1');
        $subject = new Subject($id, 'Física', $courseId);

        $this->assertSame('sub-7', $subject->id()->value());
        $this->assertSame('Física', $subject->name());
        $this->assertSame('crs-1', $subject->courseId()->value());
    }

    public function test_subject_id_cannot_be_empty(): void
    {
        $this->expectException(DomainException::class);
        new SubjectId('');
    }
}
