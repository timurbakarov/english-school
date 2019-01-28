<?php

namespace Domain\Education\StudentGroup;

use Domain\Exception\InvalidArgumentException;

class PricePerHour
{
    /**
     * @var int
     */
    private $value;

    /**
     * PricePerHour constructor.
     * @param int $value
     * @throws InvalidArgumentException
     */
    public function __construct(int $value)
    {
        if($value <= 0) {
            throw new InvalidArgumentException("Price per hour can not be lower than 0");
        }

        $this->value = $value;
    }

    /**
     * @param PricePerHour $pricePerHour
     * @return bool
     */
    public function equals(PricePerHour $pricePerHour)
    {
        return $this->value == $pricePerHour->value();
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
