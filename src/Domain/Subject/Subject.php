<?php

declare(strict_types=1);

namespace App\Domain\Subject;

use App\Domain\Course\CourseId;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;

#[Entity]
#[Table(name: 'subjects')]
final class Subject
{
    #[Id]
    #[Column(type: 'string', length: 36)]
    private string $id;

    #[Column(type: 'string')]
    private string $name;

    #[Column(type: 'string', length: 36)]
    private string $courseId;

    public function __construct(
        SubjectId $id,
        string $name,
        CourseId $courseId
    ) {
        $this->id = $id->value();
        $this->name = $name;
        $this->courseId = $courseId->value();
    }

    public function id(): SubjectId
    {
        return new SubjectId($this->id);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function courseId(): CourseId
    {
        return new CourseId($this->courseId);
    }
}