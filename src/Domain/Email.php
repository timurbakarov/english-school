<?php

namespace Domain;

class Email
{
    /**
     * @var string
     */
    private $value;

    /**
     * Email constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
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
     * @param Email $email
     * @return bool
     */
    public function equals(Email $email)
    {
        return $this->value == $email->value();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }
}
