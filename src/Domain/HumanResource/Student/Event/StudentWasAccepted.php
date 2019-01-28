<?php

namespace Domain\HumanResource\Student\Event;

use Domain\Date;
use Domain\Email;
use Domain\Phone;
use Domain\StudentId;
use Domain\HumanResource\Student;
use Domain\Contract\IdentifiesAggregate;
use Domain\Education\StudentGroup\StudentGroupId;

class StudentWasAccepted extends \Domain\DomainEvent
{
    /**
     * @var StudentId
     */
    private $studentId;

    /**
     * @var Student\Name
     */
    private $name;

    /**
     * @var Email
     */
    private $email;

    /**
     * @var Phone
     */
    private $phone;

    /**
     * @var Date
     */
    private $acceptedDate;

    /**
     * @var string
     */
    private $parents;

    /**
     * @var StudentGroupId
     */
    private $studentGroupId;

    /**
     * StudentWasAccepted constructor.
     * @param StudentId $studentId
     * @param StudentGroupId $studentGroupId
     * @param Student\Name $name
     * @param Email|null $email
     * @param Phone $phone
     * @param Date $acceptedDate
     * @param string|null $parents
     */
    public function __construct(
        StudentId $studentId,
        StudentGroupId $studentGroupId,
        Student\Name $name,
        Email $email = null,
        Phone $phone,
        Date $acceptedDate,
        string $parents = null
    ) {
        $this->studentId = $studentId;
        $this->studentGroupId = $studentGroupId;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->acceptedDate = $acceptedDate;
        $this->parents = $parents;
    }

    /**
     * The Aggregate this event belongs to.
     * @return IdentifiesAggregate
     */
    public function getAggregateId()
    {
        return $this->studentId;
    }

    /**
     * @return StudentGroupId
     */
    public function studentGroupId(): StudentGroupId
    {
        return $this->studentGroupId;
    }

    /**
     * @return Student\Name
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return Email
     */
    public function email()
    {
        return $this->email;
    }

    /**
     * @return Phone
     */
    public function phone()
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function parents()
    {
        return $this->parents;
    }

    /**
     * @return Date
     */
    public function acceptedDate()
    {
        return $this->acceptedDate;
    }

    /**
     * @return mixed
     */
    public function data(): array
    {
        return [
            'first_name' => $this->name->first(),
            'last_name' => $this->name->last(),
            'group_id' => (string)$this->studentGroupId,
            'email' => (string)$this->email,
            'phone' => (string)$this->phone,
            'accepted_date' => (string)$this->acceptedDate,
            'parents' => $this->parents,
        ];
    }

    /**
     * @param $data
     * @return \Domain\Contract\DomainEvent
     * @throws \Domain\Exception\InvalidArgumentException
     */
    public static function rebuildFromData($data): \Domain\Contract\DomainEvent
    {
        return new self(
            StudentId::fromString($data->aggregate_id),
            StudentGroupId::fromString($data->group_id),
            new Student\Name($data->first_name, $data->last_name),
            new Email($data->email),
            new Phone($data->phone),
            Date::fromString($data->accepted_date),
            $data->parents ?? ''
        );
    }

    /**
     * @param StudentId|null $studentId
     * @return \Domain\Contract\DomainEvent
     * @throws \Domain\Exception\InvalidArgumentException
     */
    public static function forTest(StudentId $studentId = null)
    {
        $data = new \stdClass();
        $data->aggregate_id = $studentId ?: StudentId::generate();
        $data->group_id = StudentGroupId::generate();
        $data->first_name = 'John';
        $data->last_name = 'Doe';
        $data->email = 'test@example.com';
        $data->phone = '+79521234567';
        $data->accepted_date = Date::fromString('2018-10-12');
        $data->parents = 'Parents';

        return self::rebuildFromData($data);
    }
}
