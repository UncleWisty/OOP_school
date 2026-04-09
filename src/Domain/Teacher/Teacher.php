<?php

declare(strict_types=1);

namespace App\Domain\Teacher;

use App\Domain\Subject\SubjectId;
use App\Domain\Shared\DomainException;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;

#[Entity]
#[Table(name: 'teachers')]
final class Teacher
{
    #[Id]
    #[Column(type: 'string', length: 36)]
    private string $id;

    #[Column(type: 'string')]
    private string $name;

    #[Column(type: 'json')]
    private array $subjects = [];

    public function __construct(
        TeacherId $id,
        string $name
    ) {
        $this->id = $id->value();
        $this->name = $name;
    }

    public function id(): TeacherId
    {
        return new TeacherId($this->id);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function subjects(): array
    {
        return $this->subjects;
    }

    public function assignSubject(SubjectId $subjectId): void
    {
        if ($this->teachesSubject($subjectId)) {
            throw new DomainException('Teacher is already assigned to this subject');
        }

        $this->subjects[] = $subjectId;
    }

    private function teachesSubject(SubjectId $subjectId): bool
    {
        foreach ($this->subjects as $assignedSubject) {
            if ($assignedSubject->value() === $subjectId->value()) {
                return true;
            }
        }
        
        return false;
    }
}