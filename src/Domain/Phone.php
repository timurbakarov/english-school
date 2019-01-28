<?php

namespace Domain;

use Domain\Exception\InvalidArgumentException;

class Phone
{
    /**
     * @var string
     */
    private $value;

    /**
     * Phone constructor.
     * @param string $value
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        if(!preg_match('/^\+79\d{2}\d{7}$/', $value)) {
            throw new InvalidArgumentException("Invalid phone number");
        }

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * @param Phone $phone
     * @return bool
     */
    public function equals(Phone $phone)
    {
        return $this->value == $phone->value();
    }
}
