<?php

namespace Domain\Education\StudentGroup\Projection;

use Domain\BaseProjection;
use App\Repository\StudentsGroupReadModel;
use Domain\Education\StudentGroup\Event\StudentGroupWasCreated;
use Domain\Education\StudentGroup\Event\StudentGroupNameWasChanged;
use Domain\HumanResource\Student\Event\StudentWasAccepted;
use Domain\HumanResource\Student\Event\StudentWasAssignedToAnotherGroup;
use Domain\Education\StudentGroup\Event\StudentGroupPricePerHourWasChanged;
use Domain\HumanResource\Student\Event\StudentWasDismissed;

class StudentsGroupProjection extends BaseProjection
{
    /**
     * @var StudentsGroupReadModel
     */
    private $studentsGroupReadModel;

    /**
     * StudentsProjection constructor.
     * @param StudentsGroupReadModel $studentsGroupReadModel
     */
    public function __construct(StudentsGroupReadModel $studentsGroupReadModel)
    {
        $this->studentsGroupReadModel = $studentsGroupReadModel;
    }

    /**
     * @return array
     */
    public function events(): array
    {
        return [
            StudentWasAccepted::class,
            StudentWasDismissed::class,
            StudentWasAssignedToAnotherGroup::class,
            StudentGroupWasCreated::class,
            StudentGroupNameWasChanged::class,
            StudentGroupPricePerHourWasChanged::class,
        ];
    }

    /**
     * @return mixed
     */
    public function readModel()
    {
        return $this->studentsGroupReadModel;
    }

    public function whenStudentWasAccepted(StudentWasAccepted $event)
    {
        $studentGroup = $this->studentsGroupReadModel->findOrFail($event->studentGroupId());
        $studentGroup->students_count++;
        $studentGroup->save();
    }

    public function whenStudentWasDismissed(StudentWasDismissed $event)
    {
        $studentGroup = $this->studentsGroupReadModel->findOrFail($event->studentGroupId());
        $studentGroup->students_count--;
        $studentGroup->save();
    }

    public function whenStudentWasAssignedToAnotherGroup(StudentWasAssignedToAnotherGroup $event)
    {
        $studentGroup = $this->studentsGroupReadModel->findOrFail($event->studentGroupToId());
        $studentGroup->students_count++;
        $studentGroup->save();

        $studentGroup = $this->studentsGroupReadModel->findOrFail($event->studentGroupFromId());
        $studentGroup->students_count--;
        $studentGroup->save();
    }

    public function whenStudentGroupWasCreated(StudentGroupWasCreated $event)
    {
        $studentGroup = $this->studentsGroupReadModel->newInstance();

        $studentGroup->id = (string)$event->getAggregateId();
        $studentGroup->name = (string)$event->name();
        $studentGroup->price_per_hour = (string)$event->pricePerHour();
        $studentGroup->created_date = (string)$event->createdDate();
        $studentGroup->is_active = 1;
        $studentGroup->students_count = 0;

        $studentGroup->saveOrFail();
    }

    public function whenStudentGroupNameWasChanged(StudentGroupNameWasChanged $event)
    {
        $studentGroup = $this->studentsGroupReadModel->findOrFail($event->getAggregateId());
        $studentGroup->name = (string)$event->name();
        $studentGroup->save();
    }

    public function whenStudentGroupPricePerHourWasChanged(StudentGroupPricePerHourWasChanged $event)
    {
        $studentGroup = $this->studentsGroupReadModel->findOrFail($event->getAggregateId());
        $studentGroup->price_per_hour = (string)$event->pricePerHour();
        $studentGroup->save();
    }
}
