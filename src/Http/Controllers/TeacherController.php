<?php

namespace App\Http\Controllers;

use App\Domain\Teacher\TeacherId;
use App\Domain\Teacher\Teacher;
use App\Http\Request;
use App\Http\ResponseJson;
use App\Infrastructure\Persistence\Doctrine\DoctrineTeacherRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class TeacherController
{
    protected Request $request;
    protected DoctrineTeacherRepository $teacherRepository;

    public function __construct(Request $request, EntityManagerInterface $em)
    {
        $this->request = $request;
        $this->teacherRepository = new DoctrineTeacherRepository($em);
    }

    public function index()
    {
        try {
            $teachers = $this->teacherRepository->findAll();
            $response = new ResponseJson(200, $teachers);
            $response->send();
        } catch (Exception $e) {
            $response = new ResponseJson(500, ['error' => $e->getMessage()]);
            $response->send();
        }
    }

    public function show(string $id)
    {
        try {
            $teacherId = new TeacherId($id);
            $teacher = $this->teacherRepository->find($teacherId);
            
            if (!$teacher) {
                $response = new ResponseJson(404, ['error' => 'Teacher not found']);
                $response->send();
                return;
            }
            
            $response = new ResponseJson(200, [
                'id' => $teacher->id()->value(),
                'name' => $teacher->name(),
                'subjects' => $teacher->subjects()
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
            
            if (!isset($body['id'], $body['name'])) {
                $response = new ResponseJson(400, ['error' => 'Missing required fields']);
                $response->send();
                return;
            }

            $teacherId = new TeacherId($body['id']);
            $teacher = new Teacher($teacherId, $body['name']);
            $this->teacherRepository->save($teacher);
            
            $response = new ResponseJson(201, [
                'id' => $teacher->id()->value(),
                'name' => $teacher->name()
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
            $teacherId = new TeacherId($id);
            
            $teacher = $this->teacherRepository->find($teacherId);
            if (!$teacher) {
                $response = new ResponseJson(404, ['error' => 'Teacher not found']);
                $response->send();
                return;
            }

            // For update, would need setter method in Teacher entity
            
            $this->teacherRepository->save($teacher);
            
            $response = new ResponseJson(200, [
                'id' => $teacher->id()->value(),
                'name' => $teacher->name(),
                'subjects' => $teacher->subjects()
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
            $teacherId = new TeacherId($id);
            $teacher = $this->teacherRepository->find($teacherId);
            
            if (!$teacher) {
                $response = new ResponseJson(404, ['error' => 'Teacher not found']);
                $response->send();
                return;
            }

            $response = new ResponseJson(204, []);
            $response->send();
        } catch (Exception $e) {
            $response = new ResponseJson(400, ['error' => $e->getMessage()]);
            $response->send();
        }
    }
}
