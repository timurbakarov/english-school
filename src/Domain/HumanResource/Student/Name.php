<?php

namespace Domain\HumanResource\Student;

class Name
{
    /**
     * @var string
     */
    private $first;

    /**
     * @var string
     */
    private $last;

    public function __construct(string $first, string $last)
    {
        $this->first = $first;
        $this->last = $last;
    }

    /**
     * @return string
     */
    public function first()
    {
        return $this->first;
    }

    /**
     * @return string
     */
    public function last()
    {
        return $this->last;
    }

    /**
     * @param Name $name
     * @return bool
     */
    public function equals(Name $name)
    {
        return $name->first() == $this->first && $name->last() == $this->last;
    }
}
