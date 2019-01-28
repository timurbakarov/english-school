<?php

namespace Domain\Finance\Student;

use Domain\Exception\InvalidArgumentException;

class PaymentType
{
    const TYPE_CASH = 'cash';
    const TYPE_ACCOUNT = 'account';

    /**
     * @var int
     */
    private $type;

    /**
     * PaymentType constructor.
     * @param string $type
     * @throws InvalidArgumentException
     */
    private function __construct(string $type)
    {
        $this->validateType($type);

        $this->type = $type;
    }

    /**
     * @return PaymentType
     * @throws InvalidArgumentException
     */
    public static function cash()
    {
        return new self(self::TYPE_CASH);
    }

    /**
     * @return PaymentType
     * @throws InvalidArgumentException
     */
    public static function account()
    {
        return new self(self::TYPE_ACCOUNT);
    }

    /**
     * @param string $type
     * @return PaymentType
     * @throws InvalidArgumentException
     */
    public static function fromString(string $type)
    {
        return new self($type);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->type;
    }

    /**
     * @param $type
     * @throws InvalidArgumentException
     */
    private function validateType($type)
    {
        if(!in_array($type, $this->validTypes())) {
            throw new InvalidArgumentException("Type is invalid");
        }
    }

    /**
     * @return array
     */
    private function validTypes()
    {
        return [
            self::TYPE_ACCOUNT,
            self::TYPE_CASH,
        ];
    }
}
