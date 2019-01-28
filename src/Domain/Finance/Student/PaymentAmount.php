<?php

namespace Domain\Finance\Student;

use Domain\Exception\InvalidArgumentException;

class PaymentAmount
{
    /**
     * @var int
     */
    private $value;

    /**
     * PaymentAmount constructor.
     * @param int $value
     * @throws InvalidArgumentException
     */
    public function __construct(int $value)
    {
        if($value < 1) {
            throw new InvalidArgumentException("Amount can not be below 0");
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
