<?php

namespace Domain\Education\StudentGroup\Schedule;

use Domain\Exception\InvalidArgumentException;

class GroupClassDuration
{
    /**
     * @var int
     */
    private $duration;

    /**
     * GroupClassDuration constructor.
     * @param int $duration
     * @throws InvalidArgumentException
     */
    public function __construct(int $duration)
    {
        if($duration < 0) {
            throw new InvalidArgumentException("Duration is invalid");
        }

        $this->duration = $duration;
    }

    /**
     * @return int
     */
    public function value()
    {
        return $this->duration;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->duration;
    }

    /**
     * @param GroupClassDuration $duration
     * @return bool
     */
    public function equals(GroupClassDuration $duration)
    {
        return $duration->value() == $this->value();
    }
}
