<?php

namespace Domain\HumanResource;

use Domain\Date;
use Domain\Email;
use Domain\Phone;
use Domain\StudentId;
use Domain\AggregateRoot;
use Domain\Contract\RecordsEvents;
use Domain\Contract\IsEventSourced;
use Domain\HumanResource\Student\Name;
use Domain\Education\StudentGroup\StudentGroupId;
use Domain\HumanResource\Student\Event\StudentWasAccepted;
use Domain\HumanResource\Student\Event\StudentWasDismissed;
use Domain\HumanResource\Student\Event\StudentWasReaccepted;
use Domain\HumanResource\Student\Event\StudentNameWasChanged;
use Domain\HumanResource\Student\Exception\StudentIsDismissedException;
use Domain\Education\StudentGroup\Exception\StudentGroupIsNotAssignable;
use Domain\HumanResource\Student\Event\StudentWasAssignedToAnotherGroup;
use Domain\Education\StudentGroup\Specification\StudentGroupAssignableSpec;

class Student implements RecordsEvents, IsEventSourced
{
    use AggregateRoot;

    const STATUS_ACTIVE = 1;
    const STATUS_DISMISSED = 2;

    /**
     * @var StudentId
     */
    private $id;

    /**
     * @var bool
     */
    private $status;

    /**
     * @var StudentGroupId
     */
    private $groupId;

    /**
     * @var array
     */
    private $statusesLog = [];

    /**
     * Student constructor.
     * @param StudentId $id
     */
    private function __construct(StudentId $id)
    {
        $this->id = $id;
    }

    /**
     * @param StudentId $studentID
     * @param StudentGroupId $studentGroupId
     * @param Name $name
     * @param Email|null $email
     * @param Phone $phone
     * @param Date $createdDate
     * @param string|null $parents
     * @return Student
     */
    public static function accept(
        StudentId $studentID,
        StudentGroupId $studentGroupId,
        Name $name,
        Email $email = null,
        Phone $phone,
        Date $createdDate,
        string $parents = null
    ) {
        $student = new self($studentID);

        $student->recordThat(new StudentWasAccepted($studentID, $studentGroupId, $name, $email, $phone, $createdDate, $parents));

        return $student;
    }

    /**
     * @param StudentWasAccepted $event
     */
    private function whenStudentWasAccepted(StudentWasAccepted $event)
    {
        $this->status = self::STATUS_ACTIVE;
        $this->id = $event->getAggregateId();
        $this->groupId = $event->studentGroupId();
        $this->statusesLog[] = [
            'status' => self::STATUS_ACTIVE,
            'date' => $event->acceptedDate(),
        ];
    }

    /**
     * @param string $reason
     * @param Date|NULL $dismissedOn
     * @return $this
     * @throws \Exception
     */
    public function dismiss(string $reason, Date $dismissedOn = null)
    {
        if($this->isDismissed()) {
            return $this;
        }

        $dismissedOn = $dismissedOn ?? Date::now();
        $lastAcceptedDate = $this->getStatusLastDate(self::STATUS_ACTIVE);

        if($dismissedOn->isLower($lastAcceptedDate)) {
            throw new \Exception('Can not be dismissed earlier than was accepted');
        }

        $this->recordThat(new StudentWasDismissed($this->id, $this->groupId, $dismissedOn, $reason));

        return $this;
    }

    private function whenStudentWasDismissed(StudentWasDismissed $event)
    {
        $this->status = self::STATUS_DISMISSED;
        $this->groupId = null;
        $this->statusesLog[] = [
            'status' => self::STATUS_DISMISSED,
            'date' => $event->dismissedOn(),
        ];
    }

    /**
     * @param StudentGroupId $studentGroupId
     * @param Date|NULL $reacceptedOn
     * @return $this
     * @throws \Exception
     */
    public function reaccept(StudentGroupId $studentGroupId, Date $reacceptedOn = null)
    {
        if(is_null($this->status)) {
            throw new \Exception('Student was not accepted yet');
        }

        if($this->isActive()) {
            throw new \Exception("Can not be reaccepted. Student is already accepted");
        }

        $reacceptedOn = $reacceptedOn ?? Date::now();
        $lastDismissionDate = $this->getStatusLastDate(self::STATUS_DISMISSED);

        if($reacceptedOn->isLower($lastDismissionDate)) {
            throw new \Exception('Can not be reaccepted earlier than was dismissed');
        }

        $this->recordThat(new StudentWasReaccepted($this->id, $studentGroupId, $reacceptedOn));

        return $this;
    }

    private function whenStudentWasReaccepted(StudentWasReaccepted $event)
    {
        $this->status = self::STATUS_ACTIVE;
        $this->groupId = $event->studentGroupId();
        $this->statusesLog[] = [
            'status' => self::STATUS_ACTIVE,
            'date' => $event->reacceptedOn(),
        ];
    }

    /**
     * @param StudentGroupId $studentGroupId
     * @param Date|NULL $assignedOn
     * @param StudentGroupAssignableSpec $studentGroupAssignableSpec
     * @return Student
     * @throws StudentGroupIsNotAssignable
     * @throws StudentIsDismissedException
     */
    public function assignToAnotherGroup(
        StudentGroupId $studentGroupId,
        Date $assignedOn = null,
        StudentGroupAssignableSpec $studentGroupAssignableSpec
    ) {
        if($this->isDismissed()) {
            throw StudentIsDismissedException::create($this->id());
        }

        if($this->groupId->equals($studentGroupId)) {
            return $this;
        }

        if(!$studentGroupAssignableSpec->isSpecifiedBy($studentGroupId)) {
            throw StudentGroupIsNotAssignable::create($studentGroupId);
        }

        $assignedOn = $assignedOn ?? Date::now();

        $this->recordThat(new StudentWasAssignedToAnotherGroup($this->id, $this->groupId, $studentGroupId, $assignedOn));

        return $this;
    }

    private function whenStudentWasAssignedToAnotherGroup(StudentWasAssignedToAnotherGroup $event)
    {
        $this->groupId = $event->studentGroupToId();
    }

    public function updateName(Name $name = null)
    {
        $this->recordThat(new StudentNameWasChanged($this->id, $name));
    }

    private function whenStudentNameWasChanged(StudentNameWasChanged $event)
    {

    }

    /**
     * @return StudentId
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @param Date $date
     */
    private function statusOnDate(Date $date)
    {
        foreach($this->statusesLog as $item) {

        }
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    /**
     * @return bool
     */
    public function isDismissed()
    {
        return $this->status == self::STATUS_DISMISSED;
    }

    /**
     * @param $status
     * @return mixed
     * @throws \Exception
     */
    private function getStatusLastDate($status)
    {
        foreach(array_reverse($this->statusesLog) as $item) {
            if($item['status'] == $status) {
                return $item['date'];
            }
        }

        throw new \Exception('Can not find last status');
    }
}
