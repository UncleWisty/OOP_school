<?php

namespace App\Http\Controllers;

use App\Domain\Course\CourseId;
use App\Domain\Course\Course;
use App\Http\Request;
use App\Http\ResponseJson;
use App\Infrastructure\Persistence\Doctrine\DoctrineCourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class CourseController
{
    protected Request $request;
    protected DoctrineCourseRepository $courseRepository;

    public function __construct(Request $request, EntityManagerInterface $em)
    {
        $this->request = $request;
        $this->courseRepository = new DoctrineCourseRepository($em);
    }

    public function index()
    {
        try {
            $courses = $this->courseRepository->findAll();
            $data = [];
            foreach ($courses as $course) {
                $data[] = [
                    'id' => $course->id()->value(),
                    'name' => $course->name()
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
            $courseId = new CourseId($id);
            $course = $this->courseRepository->find($courseId);
            
            if (!$course) {
                $response = new ResponseJson(404, ['error' => 'Course not found']);
                $response->send();
                return;
            }
            
            $response = new ResponseJson(200, [
                'id' => $course->id()->value(),
                'name' => $course->name()
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

            $courseId = new CourseId($body['id']);
            $course = new Course($courseId, $body['name']);
            $this->courseRepository->save($course);
            
            $response = new ResponseJson(201, [
                'id' => $course->id()->value(),
                'name' => $course->name()
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
            $courseId = new CourseId($id);
            
            $course = $this->courseRepository->find($courseId);
            if (!$course) {
                $response = new ResponseJson(404, ['error' => 'Course not found']);
                $response->send();
                return;
            }
            if (!isset($body['name'])) {
                $response = new ResponseJson(400, ['error' => 'Missing name for update']);
                $response->send();
                return;
            }

            $course->setName($body['name']);
            $this->courseRepository->save($course);
            
            $response = new ResponseJson(200, [
                'id' => $course->id()->value(),
                'name' => $course->name()
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
            $courseId = new CourseId($id);
            $course = $this->courseRepository->find($courseId);
            
            if (!$course) {
                $response = new ResponseJson(404, ['error' => 'Course not found']);
                $response->send();
                return;
            }

            $this->courseRepository->delete($course);

            $response = new ResponseJson(204, []);
            $response->send();
        } catch (Exception $e) {
            $response = new ResponseJson(400, ['error' => $e->getMessage()]);
            $response->send();
        }
    }
}
