<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Teacher\Teacher;
use App\Domain\Teacher\TeacherId;
use App\Domain\Shared\DomainException;

final class TeacherController
{
    public function index(): void
    {
        $teachers = $_SESSION['teachers'] ?? [];
        require __DIR__ . '/../../views/teachers/index.php';
    }

    public function store(): void
    {
        $name = $_POST['name'] ?? '';
        $id = uniqid();

        try {
            $teacher = new Teacher(new TeacherId($id), $name);
            
            $_SESSION['teachers'][] = [
                'id' => $teacher->id()->value(),
                'name' => $teacher->name()
            ];
            
            header('Location: /teachers');
            exit;
        } catch (DomainException $e) {
            $error = $e->getMessage();
            require __DIR__ . '/../../views/teachers/create.php';
        }
    }
}