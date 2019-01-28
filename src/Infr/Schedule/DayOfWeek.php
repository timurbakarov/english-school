<?php

namespace Infr\Schedule;

use Domain\Exception\InvalidArgumentException;

class DayOfWeek
{
    /**
     * @var int
     */
    private $number;

    /**
     * @var string
     */
    private $name;

    /**
     * DayOfWeek constructor.
     * @param int $number
     * @param string $name
     * @throws InvalidArgumentException
     */
    public function __construct(int $number, string $name)
    {
        if($number < 1 OR $number > 7) {
            throw new InvalidArgumentException("Number of week is invalid");
        }

        $this->number = $number;
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function number()
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }
}
