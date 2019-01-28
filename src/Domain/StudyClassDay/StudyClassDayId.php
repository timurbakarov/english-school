<?php

namespace Domain\StudyClassDay;

use Domain\Date;
use Domain\Contract\IdentifiesAggregate;

class StudyClassDayId implements IdentifiesAggregate
{
    /**
     * @var
     */
    private $id;

    /**
     * StudyClassDayId constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @param Date $date
     * @return StudyClassDayId
     */
    public static function fromDate(Date $date)
    {
        return new self(md5((string)$date));
    }

    /**
     * @return StudyClassDayId
     */
    public static function fromToday()
    {
        return new self(md5(date('Y-m-d')));
    }

    /**
     * Creates an identifier object from a string representation
     * @param $string
     * @return IdentifiesAggregate|self
     */
    public static function fromString($string)
    {
        return new self($string);
    }

    /**
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * Returns a string that can be parsed by fromString()
     * @return string
     */
    public function __toString()
    {
        return $this->id;
    }

    /**
     * Compares the object to another IdentifiesAggregate object. Returns true if both have the same type and value.
     * @param $other
     * @return boolean
     */
    public function equals(IdentifiesAggregate $other)
    {
        return $other instanceof self && $other->id() == $this->id();
    }
}
