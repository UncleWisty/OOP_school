<?php

declare(strict_types=1);

namespace App\Domain\Course;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;

#[Entity]
#[Table(name: 'courses')]
final class Course
{
    #[Id]
    #[Column(type: 'string', length: 36)]
    private string $id;

    #[Column(type: 'string')]
    private string $name;

    public function __construct(
        CourseId $id,
        string $name
    ) {
        $this->id = $id->value();
        $this->name = $name;
    }

    public function id(): CourseId
    {
        return new CourseId($this->id);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}