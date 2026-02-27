<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Enrollment\Enrollment;
use App\Domain\Enrollment\EnrollmentId;
use App\Domain\Enrollment\AcademicYear;
use App\Domain\Course\CourseId;
use App\Domain\Subject\SubjectId;
use App\Domain\Shared\DomainException;

final class EnrollmentController
{
    public function index(): void
    {
        $enrollments = $_SESSION['enrollments'] ?? [];
        require __DIR__ . '/../../views/enrollments/index.php';
    }

    public function store(): void
    {
        $studentId = $_POST['student_id'] ?? '';
        $type = $_POST['type'] ?? '';
        $startYear = (int)($_POST['start_year'] ?? date('Y'));
        $endYear = (int)($_POST['end_year'] ?? (date('Y') + 1));
        $id = uniqid();

        try {
            $academicYear = new AcademicYear($startYear, $endYear);
            $enrollmentId = new EnrollmentId($id);

            if ($type === 'full') {
                $courseId = $_POST['course_id'] ?? '';
                $enrollment = Enrollment::enrollFullCourse($enrollmentId, $academicYear, new CourseId($courseId));
                $subjectIds = [];
            } else {
                $subjectIdsPost = $_POST['subject_ids'] ?? [];
                $subjectIdObjects = array_map(fn($sid) => new SubjectId($sid), $subjectIdsPost);
                $enrollment = Enrollment::enrollPartial($enrollmentId, $academicYear, $subjectIdObjects);
                $courseId = null;
                $subjectIds = $subjectIdsPost;
            }

            $_SESSION['enrollments'][] = [
                'id' => $enrollment->id()->value(),
                'student_id' => $studentId,
                'academic_year' => $enrollment->academicYear()->value(),
                'type' => $type,
                'course_id' => $courseId,
                'subject_ids' => $subjectIds
            ];

            header('Location: /enrollments');
            exit;
        } catch (DomainException $e) {
            $error = $e->getMessage();
            $students = $_SESSION['students'] ?? [];
            $courses = $_SESSION['courses'] ?? [];
            $subjects = $_SESSION['subjects'] ?? [];
            require __DIR__ . '/../../views/enrollments/create.php';
        }
    }
}