<?php

namespace Domain\HumanResource\Student\Command;

class UpdateStudentNameCommand
{
    /**
     * @var string
     */
    private $studentId;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var null
     */
    private $parents;

    /**
     * @param string $studentId
     * @param string|NULL $firstName
     * @param string|NULL $lastName
     * @param null $parents
     */
    public function __construct(string $studentId, string $firstName = null, string $lastName = null, $parents = null)
    {
        $this->studentId = $studentId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->parents = $parents;
    }

    /**
     * @return string
     */
    public function studentId()
    {
        return $this->studentId;
    }

    /**
     * @return string
     */
    public function firstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function lastName()
    {
        return $this->lastName;
    }

    /**
     * @return null
     */
    public function parents()
    {
        return $this->parents;
    }
}
