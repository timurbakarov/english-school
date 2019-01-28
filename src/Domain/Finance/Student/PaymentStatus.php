<?php

namespace Domain\Finance\Student;

use Domain\Exception\InvalidArgumentException;

class PaymentStatus
{
    const STATUS_CREATED = 1;
    const STATUS_CANCELLED_DUE_TO_MISTAKE = 3;
    const STATUS_RETURNED = 4;

    /**
     * @var string
     */
    private $value;

    /**
     * PaymentStatus constructor.
     * @param string $status
     * @throws InvalidArgumentException
     */
    private function __construct(string $status)
    {
        $this->validateStatus($status);

        $this->value = $status;
    }

    /**
     * @return string
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * @param $status
     * @return bool
     */
    public function is($status)
    {
        if(is_array($status)) {
            return in_array($this->value, $status);
        } else {
            return $this->value == $status;
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->value;
    }

    /**
     * @param string $status
     * @return PaymentStatus
     * @throws InvalidArgumentException
     */
    public static function fromString(string $status)
    {
        return new self($status);
    }

    /**
     * @return PaymentStatus
     * @throws InvalidArgumentException
     */
    public static function created()
    {
        return new self(self::STATUS_CREATED);
    }

    /**
     * @return PaymentStatus
     * @throws InvalidArgumentException
     */
    public static function cancelled()
    {
        return new self(self::STATUS_CANCELLED_DUE_TO_MISTAKE);
    }

    /**
     * @return PaymentStatus
     * @throws InvalidArgumentException
     */
    public static function returned()
    {
        return new self(self::STATUS_RETURNED);
    }

    /**
     * @param string $status
     * @throws InvalidArgumentException
     */
    private function validateStatus(string $status)
    {
        if(!in_array($status, $this->validStatuses())) {
            throw new InvalidArgumentException("Invalid status");
        }
    }

    /**
     * @return array
     */
    private function validStatuses()
    {
        return [
            self::STATUS_CREATED,
            self::STATUS_CANCELLED_DUE_TO_MISTAKE,
            self::STATUS_RETURNED,
        ];
    }
}
