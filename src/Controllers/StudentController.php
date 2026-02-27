<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Student\Student;
use App\Domain\Student\StudentId;
use App\Domain\Student\Email;
use App\Domain\Shared\DomainException;

final class StudentController
{
    public function index(): void
    {
        $students = $_SESSION['students'] ?? [];
        require __DIR__ . '/../../views/students/index.php';
    }

    public function store(): void
    {
        $email = $_POST['email'] ?? '';
        $id = uniqid();

        try {
            $student = new Student(new StudentId($id), new Email($email));
            
            $_SESSION['students'][] = [
                'id' => $student->id()->value(),
                'email' => $student->email()->value()
            ];
            
            header('Location: /students');
            exit;
        } catch (DomainException $e) {
            $error = $e->getMessage();
            require __DIR__ . '/../../views/students/create.php';
        }
    }
}