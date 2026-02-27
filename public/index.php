<?php

declare(strict_types=1);

session_start();

require __DIR__ . '/../vendor/autoload.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestUri) {
    case '/':
        require __DIR__ . '/../views/home.php';
        break;
    case '/students':
        $controller = new \App\Controllers\StudentController();
        if ($requestMethod === 'POST') {
            $controller->store();
        } else {
            $controller->index();
        }
        break;
    case '/students/create':
        require __DIR__ . '/../views/students/create.php';
        break;
    case '/teachers':
        $controller = new \App\Controllers\TeacherController();
        if ($requestMethod === 'POST') {
            $controller->store();
        } else {
            $controller->index();
        }
        break;
    case '/teachers/create':
        require __DIR__ . '/../views/teachers/create.php';
        break;
    case '/courses':
        $controller = new \App\Controllers\CourseController();
        if ($requestMethod === 'POST') {
            $controller->store();
        } else {
            $controller->index();
        }
        break;
    case '/courses/create':
        require __DIR__ . '/../views/courses/create.php';
        break;
    case '/subjects':
        $controller = new \App\Controllers\SubjectController();
        if ($requestMethod === 'POST') {
            $controller->store();
        } else {
            $controller->index();
        }
        break;
    case '/subjects/create':
        $courses = $_SESSION['courses'] ?? [];
        require __DIR__ . '/../views/subjects/create.php';
        break;
    case '/enrollments':
        $controller = new \App\Controllers\EnrollmentController();
        if ($requestMethod === 'POST') {
            $controller->store();
        } else {
            $controller->index();
        }
        break;
    case '/enrollments/create':
        $students = $_SESSION['students'] ?? [];
        $courses = $_SESSION['courses'] ?? [];
        $subjects = $_SESSION['subjects'] ?? [];
        require __DIR__ . '/../views/enrollments/create.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/../views/404.php';
        break;
}