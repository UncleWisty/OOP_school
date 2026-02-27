<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Course\Course;
use App\Domain\Course\CourseId;
use App\Domain\Shared\DomainException;

final class CourseController
{
    public function index(): void
    {
        $courses = $_SESSION['courses'] ?? [];
        require __DIR__ . '/../../views/courses/index.php';
    }

    public function store(): void
    {
        $name = $_POST['name'] ?? '';
        $id = uniqid();

        try {
            $course = new Course(new CourseId($id), $name);
            
            $_SESSION['courses'][] = [
                'id' => $course->id()->value(),
                'name' => $course->name()
            ];
            
            header('Location: /courses');
            exit;
        } catch (DomainException $e) {
            $error = $e->getMessage();
            require __DIR__ . '/../../views/courses/create.php';
        }
    }
}