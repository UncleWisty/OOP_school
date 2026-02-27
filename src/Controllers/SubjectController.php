<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Subject\Subject;
use App\Domain\Subject\SubjectId;
use App\Domain\Course\CourseId;
use App\Domain\Shared\DomainException;

final class SubjectController
{
    public function index(): void
    {
        $subjects = $_SESSION['subjects'] ?? [];
        require __DIR__ . '/../../views/subjects/index.php';
    }

    public function store(): void
    {
        $name = $_POST['name'] ?? '';
        $courseId = $_POST['course_id'] ?? '';
        $id = uniqid();

        try {
            $subject = new Subject(new SubjectId($id), $name, new CourseId($courseId));
            
            $_SESSION['subjects'][] = [
                'id' => $subject->id()->value(),
                'name' => $subject->name(),
                'course_id' => $subject->courseId()->value()
            ];
            
            header('Location: /subjects');
            exit;
        } catch (DomainException $e) {
            $error = $e->getMessage();
            $courses = $_SESSION['courses'] ?? [];
            require __DIR__ . '/../../views/subjects/create.php';
        }
    }
}