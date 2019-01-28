<?php

namespace Domain\Projection;

use Domain\BaseProjection;
use App\Repository\StudentReadModel;
use Domain\Finance\Student\Event\StudentMadePayment;
use Domain\Finance\Student\Event\StudentPaidForLesson;
use Domain\Finance\Student\Event\StudentGotDebtForLesson;
use Domain\HumanResource\Student\Event\StudentWasAccepted;
use Domain\HumanResource\Student\Event\StudentWasDismissed;
use Domain\HumanResource\Student\Event\StudentWasReaccepted;
use Domain\HumanResource\Student\Event\StudentNameWasChanged;
use Domain\HumanResource\Student\Event\StudentWasAssignedToAnotherGroup;

class StudentsProjection extends BaseProjection
{
    /**
     * @var StudentReadModel
     */
    private $studentReadModel;

    /**
     * StudentsProjection constructor.
     * @param StudentReadModel $studentReadModel
     */
    public function __construct(StudentReadModel $studentReadModel)
    {
        $this->studentReadModel = $studentReadModel;
    }

    /**
     * @return array
     */
    public function events() : array
    {
        return [
            StudentWasAccepted::class,
            StudentWasDismissed::class,
            StudentWasAssignedToAnotherGroup::class,
            StudentMadePayment::class,
            StudentPaidForLesson::class,
            StudentGotDebtForLesson::class,
            StudentWasReaccepted::class,
            StudentNameWasChanged::class,
        ];
    }

    public function whenStudentWasAccepted(StudentWasAccepted $event)
    {
        $student = $this->studentReadModel->newInstance();

        $student->id = $event->getAggregateId();
        $student->first_name = $event->name()->first();
        $student->last_name = $event->name()->last();
        $student->phone = $event->phone();
        $student->email = $event->email();
        $student->balance = 0;
        $student->group_id = $event->studentGroupId();
        $student->parents = $event->parents();
        $student->is_active = 1;
        $student->accepted_date = (string)$event->acceptedDate();

        $student->save();
    }

    public function whenStudentWasDismissed(StudentWasDismissed $event)
    {
        $student = $this->studentReadModel->findOrFail((string)$event->getAggregateId());
        $student->is_active = 0;
        $student->group_id = null;
        $student->saveOrFail();
    }

    public function whenStudentWasAssignedToAnotherGroup(StudentWasAssignedToAnotherGroup $event)
    {
        $student = $this->studentReadModel->findOrFail((string)$event->getAggregateId());
        $student->group_id = (string)$event->studentGroupToId();
        $student->save();
    }

    public function whenStudentMadePayment(StudentMadePayment $event)
    {
        $student = $this->studentReadModel->findOrFail((string)$event->getAggregateId());
        $student->balance = $student->balance + $event->amount()->value();
        $student->save();
    }

    public function whenStudentPaidForLesson(StudentPaidForLesson $event)
    {
        $student = $this->studentReadModel->findOrFail((string)$event->getAggregateId());
        $student->balance = $student->balance - $event->amount()->value();
        $student->save();
    }

    public function whenStudentGotDebtForLesson(StudentGotDebtForLesson $event)
    {
        $student = $this->studentReadModel->findOrFail((string)$event->getAggregateId());
        $student->balance = $student->balance - $event->amount()->value();
        $student->save();
    }

    public function whenStudentWasReaccepted(StudentWasReaccepted $event)
    {
        $student = $this->studentReadModel->findOrFail((string)$event->getAggregateId());
        $student->is_active = 1;
        $student->group_id = (string)$event->studentGroupId();
        $student->save();
    }

    public function whenStudentNameWasChanged(StudentNameWasChanged $event)
    {
        $student = $this->studentReadModel->findOrFail((string)$event->getAggregateId());
        $student->first_name = (string)$event->name()->first();
        $student->last_name = (string)$event->name()->last();
        $student->save();
    }

    /**
     * @return mixed
     */
    public function readModel()
    {
        return $this->studentReadModel;
    }
}
