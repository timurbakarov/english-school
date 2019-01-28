<?php

namespace Domain\Education\StudentGroup\Command;

class ChangeStudentGroupNameCommand
{
    /**
     * @var string
     */
    private $studentGroupId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $changedOn;

    /**
     * @param string $studentGroupId
     * @param string $name
     * @param string|null $changedOn
     */
    public function __construct(string $studentGroupId, string $name, string $changedOn = null)
    {
        $this->studentGroupId = $studentGroupId;
        $this->name = $name;
        $this->changedOn = $changedOn;
    }

    /**
     * @return string
     */
    public function studentGroupId(): string
    {
        return $this->studentGroupId;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function changedOn()
    {
        return $this->changedOn;
    }
}
