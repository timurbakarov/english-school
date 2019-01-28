<?php

namespace Domain\Education\StudentGroup;

use Domain\Exception\InvalidArgumentException;

class StudentGroupName
{
    /**
     * @var string
     */
    private $value;

    /**
     * Name constructor.
     * @param string $value
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        if(!trim($value)) {
            throw new InvalidArgumentException("Student group name can not be empty");
        }

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * @param StudentGroupName $name
     * @return bool
     */
    public function equals(self $name)
    {
        return $this->value == $name->value();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }
}
