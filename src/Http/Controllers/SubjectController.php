<?php

namespace App\Http\Controllers;

use App\Domain\Subject\SubjectId;
use App\Domain\Subject\Subject;
use App\Domain\Course\CourseId;
use App\Http\Request;
use App\Http\ResponseJson;
use App\Infrastructure\Persistence\Doctrine\DoctrineSubjectRepository;
use App\Infrastructure\Persistence\Doctrine\DoctrineCourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class SubjectController
{
    protected Request $request;
    protected DoctrineSubjectRepository $subjectRepository;
    protected DoctrineCourseRepository $courseRepository;

    public function __construct(Request $request, EntityManagerInterface $em)
    {
        $this->request = $request;
        $this->subjectRepository = new DoctrineSubjectRepository($em);
        $this->courseRepository = new DoctrineCourseRepository($em);
    }

    public function index()
    {
        try {
            $subjects = $this->subjectRepository->findAll();
            $data = [];
            foreach ($subjects as $subject) {
                $data[] = [
                    'id' => $subject->id()->value(),
                    'name' => $subject->name(),
                    'courseId' => $subject->courseId()->value()
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
            $subjectId = new SubjectId($id);
            $subject = $this->subjectRepository->find($subjectId);
            
            if (!$subject) {
                $response = new ResponseJson(404, ['error' => 'Subject not found']);
                $response->send();
                return;
            }
            
            $response = new ResponseJson(200, [
                'id' => $subject->id()->value(),
                'name' => $subject->name(),
                'courseId' => $subject->courseId()->value()
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
            
            if (!isset($body['id'], $body['name'], $body['courseId'])) {
                $response = new ResponseJson(400, ['error' => 'Missing required fields']);
                $response->send();
                return;
            }

            $subjectId = new SubjectId($body['id']);
            $courseId = new CourseId($body['courseId']);

            // para verificar que existe el curso antes de insertarla!!!
            $course = $this->courseRepository->find($courseId);
            if (!$course) {
                $response = new ResponseJson(404, ['error' => 'Course not found']);
                $response->send();
                return;
            }

            $subject = new Subject($subjectId, $body['name'], $courseId);
            $this->subjectRepository->save($subject);
            
            $response = new ResponseJson(201, [
                'id' => $subject->id()->value(),
                'name' => $subject->name(),
                'courseId' => $subject->courseId()->value()
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
            $subjectId = new SubjectId($id);
            
            $subject = $this->subjectRepository->find($subjectId);
            if (!$subject) {
                $response = new ResponseJson(404, ['error' => 'Subject not found']);
                $response->send();
                return;
            }
            if (!isset($body['name'])) {
                $response = new ResponseJson(400, ['error' => 'Missing name for update']);
                $response->send();
                return;
            }

            $subject->setName($body['name']);
            $this->subjectRepository->save($subject);

            $response = new ResponseJson(200, [
                'id' => $subject->id()->value(),
                'name' => $subject->name(),
                'courseId' => $subject->courseId()->value()
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
            $subjectId = new SubjectId($id);
            $subject = $this->subjectRepository->find($subjectId);
            
            if (!$subject) {
                $response = new ResponseJson(404, ['error' => 'Subject not found']);
                $response->send();
                return;
            }

            $this->subjectRepository->delete($subject);

            $response = new ResponseJson(204, []);
            $response->send();
        } catch (Exception $e) {
            $response = new ResponseJson(400, ['error' => $e->getMessage()]);
            $response->send();
        }
    }
}
