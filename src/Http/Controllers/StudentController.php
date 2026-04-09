<?php

namespace App\Http\Controllers;

use App\Domain\Student\StudentId;
use App\Domain\Student\Email;
use App\Domain\Student\Student;
use App\Http\Request;
use App\Http\ResponseJson;
use App\Infrastructure\Persistence\Doctrine\DoctrineStudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class StudentController
{
    protected Request $request;
    protected DoctrineStudentRepository $studentRepository;

    public function __construct(Request $request, EntityManagerInterface $em)
    {
        $this->request = $request;
        $this->studentRepository = new DoctrineStudentRepository($em);
    }

    public function index()
    {
        try {
            $students = $this->studentRepository->findAll();
            $data = [];
            foreach ($students as $student) {
                $enrollments = [];
                foreach ($student->enrollments() as $en) {
                    $enrollments[] = [
                        'id' => $en->id()->value(),
                        'academicYear' => $en->academicYear()->value(),
                        'isFullCourse' => $en->isFullCourse(),
                        'courseId' => $en->isFullCourse() ? $en->courseId()->value() : null,
                        'subjectIds' => $en->subjectIds()
                    ];
                }

                $data[] = [
                    'id' => $student->id()->value(),
                    'email' => $student->email()->value(),
                    'enrollments' => $enrollments
                ];
            }
            $response = new ResponseJson(200, $data);
            $response->send();
        } catch (Exception $e) {
            $response = new ResponseJson(500, ['error' => $e->getMessage()]);
            $response->send();
        }
    }

    public function show(string $id)
    {
        try {
            $studentId = new StudentId($id);
            $student = $this->studentRepository->find($studentId);
            
            if (!$student) {
                $response = new ResponseJson(404, ['error' => 'Student not found']);
                $response->send();
                return;
            }
            $enrollments = [];
            foreach ($student->enrollments() as $en) {
                $enrollments[] = [
                    'id' => $en->id()->value(),
                    'academicYear' => $en->academicYear()->value(),
                    'isFullCourse' => $en->isFullCourse(),
                    'courseId' => $en->isFullCourse() ? $en->courseId()->value() : null,
                    'subjectIds' => $en->subjectIds()
                ];
            }

            $response = new ResponseJson(200, [
                'id' => $student->id()->value(),
                'email' => $student->email()->value(),
                'enrollments' => $enrollments
            ]);
            $response->send();
        } catch (Exception $e) {
            $response = new ResponseJson(400, ['error' => $e->getMessage()]);
            $response->send();
        }
    }

    public function create()
    {
        try {
            $body = $this->request->getBody();
            
            if (!isset($body['id'], $body['email'])) {
                $response = new ResponseJson(400, ['error' => 'Missing required fields']);
                $response->send();
                return;
            }

            $studentId = new StudentId($body['id']);
            $email = new Email($body['email']);
            
            $student = new Student($studentId, $email);
            $this->studentRepository->save($student);
            
            $response = new ResponseJson(201, [
                'id' => $student->id()->value(),
                'email' => $student->email()->value()
            ]);
            $response->send();
        } catch (Exception $e) {
            $response = new ResponseJson(400, ['error' => $e->getMessage()]);
            $response->send();
        }
    }

    public function update(string $id)
    {
        try {
            $body = $this->request->getBody();
            $studentId = new StudentId($id);
            
            $student = $this->studentRepository->find($studentId);
            if (!$student) {
                $response = new ResponseJson(404, ['error' => 'Student not found']);
                $response->send();
                return;
            }

            // For now, we can update email if provided
            if (isset($body['email'])) {
                $email = new Email($body['email']);
                $student->setEmail($email);
            }
            
            $this->studentRepository->save($student);
            
            $response = new ResponseJson(200, [
                'id' => $student->id()->value(),
                'email' => $student->email()->value()
            ]);
            $response->send();
        } catch (Exception $e) {
            $response = new ResponseJson(400, ['error' => $e->getMessage()]);
            $response->send();
        }
    }

    public function delete(string $id)
    {
        try {
            $studentId = new StudentId($id);
            $student = $this->studentRepository->find($studentId);
            
            if (!$student) {
                $response = new ResponseJson(404, ['error' => 'Student not found']);
                $response->send();
                return;
            }

            $this->studentRepository->delete($student);

            $response = new ResponseJson(204, []);
            $response->send();
        } catch (Exception $e) {
            $response = new ResponseJson(400, ['error' => $e->getMessage()]);
            $response->send();
        }
    }
}
