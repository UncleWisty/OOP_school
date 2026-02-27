<?php

declare(strict_types=1);

namespace Tests\Domain\Teacher;

use PHPUnit\Framework\TestCase;
use App\Domain\Teacher\Teacher;
use App\Domain\Teacher\TeacherId;
use App\Domain\Subject\SubjectId;
use App\Domain\Shared\DomainException;

final class TeacherTest extends TestCase
{
    public function test_teacher_can_be_assigned_to_subject(): void
    {
        $teacher = new Teacher(new TeacherId('tch-1'), 'Anna');
        $teacher->assignSubject(new SubjectId('sub-1'));

        $this->assertCount(1, $teacher->subjects());
    }

    public function test_teacher_cannot_be_assigned_twice_to_same_subject(): void
    {
        $teacher = new Teacher(new TeacherId('tch-1'), 'Anna');
        $subjectId = new SubjectId('sub-1');
        
        $teacher->assignSubject($subjectId);

        $this->expectException(DomainException::class);
        $teacher->assignSubject(new SubjectId('sub-1'));
    }

    public function test_getters_return_expected_values(): void
    {
        $id = new TeacherId('tch-99');
        $teacher = new Teacher($id, 'Bernat');

        $this->assertSame($id->value(), $teacher->id()->value());
        $this->assertSame('Bernat', $teacher->name());
    }

    public function test_teacher_can_be_assigned_multiple_different_subjects(): void
    {
        $teacher = new Teacher(new TeacherId('tch-1'), 'Anna');

        $teacher->assignSubject(new SubjectId('sub-1'));
        $teacher->assignSubject(new SubjectId('sub-2'));
        $teacher->assignSubject(new SubjectId('sub-3'));

        $this->assertCount(3, $teacher->subjects());
        $this->assertSame('sub-1', $teacher->subjects()[0]->value());
        $this->assertSame('sub-2', $teacher->subjects()[1]->value());
        $this->assertSame('sub-3', $teacher->subjects()[2]->value());
    }
}