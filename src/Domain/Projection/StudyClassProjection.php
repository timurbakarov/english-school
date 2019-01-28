<?php

namespace Domain\Projection;

use Domain\BaseProjection;
use App\Repository\StudyClassReadModel;
use Domain\Education\Lesson\Event\LessonWasGiven;
use Domain\Education\Lesson\Event\StudentAttendedLesson;

class StudyClassProjection extends BaseProjection
{
    /**
     * @var StudyClassReadModel
     */
    private $studyClassReadModel;

    /**
     * StudyClassProjection constructor.
     * @param StudyClassReadModel $studyClassReadModel
     */
    public function __construct(StudyClassReadModel $studyClassReadModel)
    {
        $this->studyClassReadModel = $studyClassReadModel;
    }

    /**
     * @return array
     */
    public function events(): array
    {
        return [
            LessonWasGiven::class,
            StudentAttendedLesson::class,
        ];
    }

    /**
     * @param LessonWasGiven $event
     * @throws \Throwable
     */
    public function whenLessonWasGiven(LessonWasGiven $event)
    {
        $studyClass = $this->studyClassReadModel->newInstance();

        $studyClass->study_class_id = $event->getAggregateId();
        $studyClass->group_id = (string)$event->studentGroupId();
        $studyClass->date = (string)$event->date();
        $studyClass->price_per_hour = (string)$event->pricePerHour();
        $studyClass->duration = (string)$event->duration();
        $studyClass->hour = (string)$event->time()->hour();
        $studyClass->minutes = (string)$event->time()->minutes();

        $studyClass->saveOrFail();
    }

    public function whenStudentAttendedLesson(StudentAttendedLesson $event)
    {
        $studyClass = $this->studyClassReadModel->findOrFail((string)$event->getAggregateId());
        $studyClass->students_count += 1;
        $studyClass->save();
    }

    /**
     * @return mixed
     */
    public function readModel()
    {
        return $this->studyClassReadModel;
    }
}
