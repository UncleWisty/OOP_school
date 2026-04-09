<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\EnrollmentController;

return [
    // Student endpoints
    [
        'method' => 'GET',
        'path' => '/api/students',
        'handler' => [StudentController::class, 'index']
    ],
    [
        'method' => 'GET',
        'path' => '/api/students/{id}',
        'handler' => [StudentController::class, 'show']
    ],
    [
        'method' => 'POST',
        'path' => '/api/students',
        'handler' => [StudentController::class, 'create']
    ],
    [
        'method' => 'PUT',
        'path' => '/api/students/{id}',
        'handler' => [StudentController::class, 'update']
    ],
    [
        'method' => 'DELETE',
        'path' => '/api/students/{id}',
        'handler' => [StudentController::class, 'delete']
    ],
    
    // Course endpoints
    [
        'method' => 'GET',
        'path' => '/api/courses',
        'handler' => [CourseController::class, 'index']
    ],
    [
        'method' => 'GET',
        'path' => '/api/courses/{id}',
        'handler' => [CourseController::class, 'show']
    ],
    [
        'method' => 'POST',
        'path' => '/api/courses',
        'handler' => [CourseController::class, 'create']
    ],
    [
        'method' => 'PUT',
        'path' => '/api/courses/{id}',
        'handler' => [CourseController::class, 'update']
    ],
    [
        'method' => 'DELETE',
        'path' => '/api/courses/{id}',
        'handler' => [CourseController::class, 'delete']
    ],
    
    // Teacher endpoints
    [
        'method' => 'GET',
        'path' => '/api/teachers',
        'handler' => [TeacherController::class, 'index']
    ],
    [
        'method' => 'GET',
        'path' => '/api/teachers/{id}',
        'handler' => [TeacherController::class, 'show']
    ],
    [
        'method' => 'POST',
        'path' => '/api/teachers',
        'handler' => [TeacherController::class, 'create']
    ],
    [
        'method' => 'PUT',
        'path' => '/api/teachers/{id}',
        'handler' => [TeacherController::class, 'update']
    ],
    [
        'method' => 'DELETE',
        'path' => '/api/teachers/{id}',
        'handler' => [TeacherController::class, 'delete']
    ],
    
    // Subject endpoints
    [
        'method' => 'GET',
        'path' => '/api/subjects',
        'handler' => [SubjectController::class, 'index']
    ],
    [
        'method' => 'GET',
        'path' => '/api/subjects/{id}',
        'handler' => [SubjectController::class, 'show']
    ],
    [
        'method' => 'POST',
        'path' => '/api/subjects',
        'handler' => [SubjectController::class, 'create']
    ],
    [
        'method' => 'PUT',
        'path' => '/api/subjects/{id}',
        'handler' => [SubjectController::class, 'update']
    ],
    [
        'method' => 'DELETE',
        'path' => '/api/subjects/{id}',
        'handler' => [SubjectController::class, 'delete']
    ],
    
    // Enrollment endpoints
    [
        'method' => 'GET',
        'path' => '/api/enrollments',
        'handler' => [EnrollmentController::class, 'index']
    ],
    [
        'method' => 'GET',
        'path' => '/api/enrollments/{id}',
        'handler' => [EnrollmentController::class, 'show']
    ],
    [
        'method' => 'POST',
        'path' => '/api/enrollments',
        'handler' => [EnrollmentController::class, 'create']
    ],
    [
        'method' => 'PUT',
        'path' => '/api/enrollments/{id}',
        'handler' => [EnrollmentController::class, 'update']
    ],
    [
        'method' => 'DELETE',
        'path' => '/api/enrollments/{id}',
        'handler' => [EnrollmentController::class, 'delete']
    ]
];
