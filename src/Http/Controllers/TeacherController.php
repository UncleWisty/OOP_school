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
            $data = [];
            foreach ($teachers as $teacher) {
                $subjects = [];
                foreach ($teacher->subjects() as $s) {
                    $subjects[] = $s instanceof \App\Domain\Subject\SubjectId ? $s->value() : $s;
                }

                $data[] = [
                    'id' => $teacher->id()->value(),
                    'name' => $teacher->name(),
                    'subjects' => $subjects
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
            // Prevent creating a teacher with an ID that already exists
            $existing = $this->teacherRepository->find($teacherId);
            if ($existing) {
                $response = new ResponseJson(409, ['error' => 'Teacher with this id already exists']);
                $response->send();
                return;
            }
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
            if (!isset($body['name'])) {
                $response = new ResponseJson(400, ['error' => 'Missing name for update']);
                $response->send();
                return;
            }

            $teacher->setName($body['name']);
            $this->teacherRepository->save($teacher);

            $subjects = [];
            foreach ($teacher->subjects() as $s) {
                $subjects[] = $s instanceof \App\Domain\Subject\SubjectId ? $s->value() : $s;
            }

            $response = new ResponseJson(200, [
                'id' => $teacher->id()->value(),
                'name' => $teacher->name(),
                'subjects' => $subjects
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

            $this->teacherRepository->delete($teacher);

            // No content for successful delete
            $response = new ResponseJson(204, []);
            $response->send();
        } catch (Exception $e) {
            $response = new ResponseJson(400, ['error' => $e->getMessage()]);
            $response->send();
        }
    }
}
