<?php

namespace Domain;

use Domain\Contract\IdentifiesAggregate;
use Domain\Exception\InvalidArgumentException;

class LessonId implements IdentifiesAggregate
{
    /**
     * @var string
     */
    private $id;

    /**
     * @param string $id
     * @throws InvalidArgumentException
     */
    private function __construct(string $id)
    {
        if(!$this->isValidMd5($id)) {
            throw new InvalidArgumentException('Id is not valid');
        }

        $this->id = $id;
    }

    /**
     * @param Date $date
     * @param Time $time
     * @return LessonId
     * @throws InvalidArgumentException
     */
    public static function generate(Date $date = null, Time $time = null)
    {
        $date = $date ?? Date::now();
        $time = $time ?? Time::now();

        return new self(md5((string)$date . (string)$time));
    }

    /**
     * Creates an identifier object from a string representation
     * @param $string
     * @return IdentifiesAggregate|self
     * @throws InvalidArgumentException
     */
    public static function fromString($string)
    {
        return new self($string);
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
        return $this->id == (string)$other;
    }

    /**
     * @param string $id
     * @return false|int
     */
    private function isValidMd5(string $id)
    {
        return preg_match('/^[a-f0-9]{32}$/', $id);
    }
}
