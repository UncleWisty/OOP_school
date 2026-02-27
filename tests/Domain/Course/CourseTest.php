<?php

declare(strict_types=1);

namespace Tests\Domain\Course;

use PHPUnit\Framework\TestCase;
use App\Domain\Course\Course;
use App\Domain\Course\CourseId;
use App\Domain\Shared\DomainException;

final class CourseTest extends TestCase
{
    public function test_course_can_be_created_and_getters_work(): void
    {
        $id = new CourseId('crs-10');
        $course = new Course($id, 'Matemàtiques');

        $this->assertSame('crs-10', $course->id()->value());
        $this->assertSame('Matemàtiques', $course->name());
    }

    public function test_course_id_cannot_be_empty(): void
    {
        $this->expectException(DomainException::class);
        new CourseId('');
    }
}
