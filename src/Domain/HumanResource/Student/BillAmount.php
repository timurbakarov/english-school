<?php

namespace Domain\HumanResource\Student;

use Domain\Exception\InvalidArgumentException;

class BillAmount
{
    /**
     * @var int
     */
    private $value;

    /**
     * BillAmount constructor.
     * @param int $value
     * @throws InvalidArgumentException
     */
    public function __construct(int $value)
    {
        if($value < 1) {
            throw new InvalidArgumentException("Value is invalid");
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
}
