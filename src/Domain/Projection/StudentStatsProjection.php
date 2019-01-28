<?php

namespace Domain\Projection;

use App\Repository\StudyClassReadModel;
use Domain\BaseProjection;
use App\Repository\StudentsStatsReadModel;
use Domain\Education\Lesson\Event\StudentMissedLessonWasUnmarked;
use Domain\Finance\Student\Event\StudentMadePayment;
use Domain\Education\Lesson\Event\StudentMissedLesson;
use Domain\Education\Lesson\Event\StudentAttendedLesson;

class StudentStatsProjection extends BaseProjection
{
    /**
     * @var StudentsStatsReadModel
     */
    private $studentsStatsReadModel;

    /**
     * @var StudyClassReadModel
     */
    private $studyClassReadModel;

    /**
     * StudentStatsProjection constructor.
     * @param StudentsStatsReadModel $studentsStatsReadModel
     */
    public function __construct(StudentsStatsReadModel $studentsStatsReadModel, StudyClassReadModel $studyClassReadModel)
    {
        $this->studentsStatsReadModel = $studentsStatsReadModel;
        $this->studyClassReadModel = $studyClassReadModel;
    }

    /**
     * @return array
     */
    public function events(): array
    {
        return [
            StudentMadePayment::class,
            StudentMissedLesson::class,
            StudentMissedLessonWasUnmarked::class,
            StudentAttendedLesson::class,
        ];
    }

    public function whenStudentMadePayment(StudentMadePayment $event)
    {
        $stat = $this->row((string)$event->getAggregateId());
        $stat->payments = $stat->payments + $event->amount()->value();
        $stat->saveOrFail();
    }

    public function whenStudentAttendedLesson(StudentAttendedLesson $event)
    {
        $lesson = $this->studyClassReadModel->findOrFail((string)$event->getAggregateId());

        $stat = $this->row((string)$event->studentId());
        $stat->visited_classes_in_money += $lesson->duration * $lesson->price_per_hour;
        $stat->visited_classes += 1;
        $stat->saveOrFail();
    }

    public function whenStudentMissedLessonWasUnmarked(StudentMissedLessonWasUnmarked $event)
    {
        $stat = $this->row((string)$event->studentId());
        $stat->missed_classes -= 1;
        $stat->saveOrFail();
    }

    public function whenStudentMissedLesson(StudentMissedLesson $event)
    {
        $stat = $this->row((string)$event->studentId());
        $stat->missed_classes += 1;
        $stat->saveOrFail();
    }

    /**
     * @return mixed
     */
    public function readModel()
    {
        return $this->studentsStatsReadModel;
    }

    private function row(string $studentId)
    {
        $stat = $this->studentsStatsReadModel->find($studentId);

        if(!$stat) {
            $stat = $this->studentsStatsReadModel->newInstance();
            $stat->student_id = $studentId;
        }

        return $stat;
    }
}
