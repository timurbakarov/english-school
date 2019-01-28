<?php

namespace Domain\Education\StudentGroup\Command;

class ChangeStudentGroupPricePerHourCommand
{
    /**
     * @var string
     */
    private $studentGroupId;

    /**
     * @var int
     */
    private $pricePerHour;

    /**
     * @var string
     */
    private $changedOn;

    /**
     * @param string $studentGroupId
     * @param int $pricePerHour
     * @param string|null $changedOn
     */
    public function __construct(string $studentGroupId, int $pricePerHour, string $changedOn = null)
    {
        $this->studentGroupId = $studentGroupId;
        $this->pricePerHour = $pricePerHour;
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
     * @return int
     */
    public function pricePerHour(): int
    {
        return $this->pricePerHour;
    }

    /**
     * @return string
     */
    public function changedOn()
    {
        return $this->changedOn;
    }
}
