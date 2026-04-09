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
            $response = new ResponseJson(200, $students);
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
            
            $response = new ResponseJson(200, [
                'id' => $student->id()->value(),
                'email' => $student->email()->value(),
                'enrollments' => $student->enrollments()
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
                // We would need a setter method in Student entity
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

            // Doctrine remove
            $response = new ResponseJson(204, []);
            $response->send();
        } catch (Exception $e) {
            $response = new ResponseJson(400, ['error' => $e->getMessage()]);
            $response->send();
        }
    }
}
