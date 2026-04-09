<?php

namespace App\Http\Controllers;

use App\Domain\Enrollment\EnrollmentId;
use App\Domain\Enrollment\Enrollment;
use App\Domain\Enrollment\AcademicYear;
use App\Domain\Course\CourseId;
use App\Domain\Subject\SubjectId;
use App\Http\Request;
use App\Http\ResponseJson;
use App\Infrastructure\Persistence\Doctrine\DoctrineEnrollmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class EnrollmentController
{
    protected Request $request;
    protected DoctrineEnrollmentRepository $enrollmentRepository;

    public function __construct(Request $request, EntityManagerInterface $em)
    {
        $this->request = $request;
        $this->enrollmentRepository = new DoctrineEnrollmentRepository($em);
    }

    public function index()
    {
        try {
            $enrollments = $this->enrollmentRepository->findAll();
            $data = [];
            foreach ($enrollments as $enrollment) {
                $item = [
                    'id' => $enrollment->id()->value(),
                    'academicYear' => $enrollment->academicYear()->value(),
                    'isFullCourse' => $enrollment->isFullCourse()
                ];

                if ($enrollment->isFullCourse()) {
                    $item['courseId'] = $enrollment->courseId()->value();
                } else {
                    $item['subjectIds'] = $enrollment->subjectIds();
                }

                $data[] = $item;
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
            $enrollmentId = new EnrollmentId($id);
            $enrollment = $this->enrollmentRepository->find($enrollmentId);
            
            if (!$enrollment) {
                $response = new ResponseJson(404, ['error' => 'Enrollment not found']);
                $response->send();
                return;
            }
            
            $data = [
                'id' => $enrollment->id()->value(),
                'academicYear' => $enrollment->academicYear()->value(),
                'isFullCourse' => $enrollment->isFullCourse(),
            ];
            
            if ($enrollment->isFullCourse()) {
                $data['courseId'] = $enrollment->courseId()->value();
            } else {
                $data['subjectIds'] = $enrollment->subjectIds();
            }
            
            $response = new ResponseJson(200, $data);
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
            
            if (!isset($body['id'], $body['academicYear'], $body['academicYearEnd'])) {
                $response = new ResponseJson(400, ['error' => 'Missing required fields']);
                $response->send();
                return;
            }

            $enrollmentId = new EnrollmentId($body['id']);
            $academicYear = new AcademicYear($body['academicYear'], $body['academicYearEnd']);
            
            if (isset($body['courseId'])) {
                // Full course enrollment
                $courseId = new CourseId($body['courseId']);
                $enrollment = Enrollment::enrollFullCourse($enrollmentId, $academicYear, $courseId);
            } elseif (isset($body['subjectIds']) && is_array($body['subjectIds'])) {
                // Partial enrollment
                $subjectIds = array_map(fn($id) => new SubjectId($id), $body['subjectIds']);
                $enrollment = Enrollment::enrollPartial($enrollmentId, $academicYear, $subjectIds);
            } else {
                $response = new ResponseJson(400, ['error' => 'Either courseId or subjectIds must be provided']);
                $response->send();
                return;
            }
            
            $this->enrollmentRepository->save($enrollment);
            
            $data = [
                'id' => $enrollment->id()->value(),
                'academicYear' => $enrollment->academicYear()->value(),
                'isFullCourse' => $enrollment->isFullCourse(),
            ];
            
            if ($enrollment->isFullCourse()) {
                $data['courseId'] = $enrollment->courseId()->value();
            } else {
                $data['subjectIds'] = $enrollment->subjectIds();
            }
            
            $response = new ResponseJson(201, $data);
            $response->send();
        } catch (Exception $e) {
            $response = new ResponseJson(400, ['error' => $e->getMessage()]);
            $response->send();
        }
    }

    public function update(string $id)
    {
        try {
            $enrollmentId = new EnrollmentId($id);
            
            $enrollment = $this->enrollmentRepository->find($enrollmentId);
            if (!$enrollment) {
                $response = new ResponseJson(404, ['error' => 'Enrollment not found']);
                $response->send();
                return;
            }

            // Enrollments are typically immutable, so updates might not be allowed
            $response = new ResponseJson(405, ['error' => 'Enrollments cannot be updated']);
            $response->send();
        } catch (Exception $e) {
            $response = new ResponseJson(400, ['error' => $e->getMessage()]);
            $response->send();
        }
    }

    public function delete(string $id)
    {
        try {
            $enrollmentId = new EnrollmentId($id);
            $enrollment = $this->enrollmentRepository->find($enrollmentId);
            
            if (!$enrollment) {
                $response = new ResponseJson(404, ['error' => 'Enrollment not found']);
                $response->send();
                return;
            }

            $this->enrollmentRepository->delete($enrollment);

            $response = new ResponseJson(204, []);
            $response->send();
        } catch (Exception $e) {
            $response = new ResponseJson(400, ['error' => $e->getMessage()]);
            $response->send();
        }
    }
}
