<?php

namespace Domain\Education\StudentGroup\Schedule;

use Domain\Exception\InvalidArgumentException;

class DayOfWeek
{
    /**
     * @var int
     */
    private $value;

    /**
     * DayOfWeek constructor.
     * @param int $value
     * @throws InvalidArgumentException
     */
    public function __construct(int $value)
    {
        if($value < 1 OR $value > 7) {
            throw new InvalidArgumentException("Day of week is invalid");
        }

        $this->value = $value;
    }

    /**
     * @return int
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->value;
    }

    /**
     * @param DayOfWeek $dayOfWeek
     * @return bool
     */
    public function equals(DayOfWeek $dayOfWeek): bool
    {
        return $this->value == $dayOfWeek->value();
    }
}
