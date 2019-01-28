<?php

namespace Domain\HumanResource\Student;

use Domain\Exception\InvalidArgumentException;

class Balance
{
    /**
     * @var int
     */
    private $value;

    /**
     * Balance constructor.
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @param int $amount
     * @return bool
     */
    public function hasEnough(int $amount)
    {
        return $this->value >= $amount;
    }

    /**
     * @return int
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * @param int $amount
     * @return Balance
     */
    public function change(int $amount)
    {
        $this->value += $amount;

        return $this;
    }

    /**
     * @param int $amount
     * @return Balance
     * @throws InvalidArgumentException
     */
    public function increase(int $amount)
    {
        if($amount < 1) {
            throw new InvalidArgumentException("Amount is invalid");
        }

        return $this->change($amount);
    }

    /**
     * @param int $amount
     * @return Balance
     * @throws InvalidArgumentException
     */
    public function reduce(int $amount)
    {
        if($amount < 1) {
            throw new InvalidArgumentException("Amount is invalid");
        }

        return $this->change(-$amount);
    }

    /**
     * @param Balance $balance
     * @return bool
     */
    public function equals(Balance $balance)
    {
        return $balance->value() == $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->value;
    }
}
