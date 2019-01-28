<?php

namespace Domain\HumanResource\Student\Command;

class AcceptStudentCommand
{
    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $groupId;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $acceptedDate;

    /**
     * @var string
     */
    private $parents;

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $groupId
     * @param string|NULL $email
     * @param string $phone
     * @param string $acceptedDate
     * @param string $parents
     */
    public function __construct(
        string $firstName,
        string $lastName,
        string $groupId,
        string $email = null,
        string $phone,
        string $acceptedDate,
        string $parents = ''
    ) {

        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->groupId = $groupId;
        $this->email = $email;
        $this->phone = $phone;
        $this->acceptedDate = $acceptedDate;
        $this->parents = $parents;
    }

    /**
     * @return string
     */
    public function firstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function lastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function groupId(): string
    {
        return $this->groupId;
    }

    /**
     * @return string
     */
    public function email()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function phone(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function acceptedDate(): string
    {
        return $this->acceptedDate;
    }

    /**
     * @return string
     */
    public function parents(): string
    {
        return $this->parents;
    }
}
