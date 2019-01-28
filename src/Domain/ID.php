<?php

namespace Domain;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Domain\Contract\IdentifiesAggregate;

abstract class ID implements IdentifiesAggregate
{
    /**
     * @var UuidInterface
     */
    protected $id;

    /**
     * ID constructor.
     * @param UuidInterface $id
     */
    public function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->__toString();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id->toString();
    }

    /**
     * @return static
     */
    public static function generate()
    {
        return new static(Uuid::uuid4());
    }

    /**
     * @param $string
     * @return IdentifiesAggregate|static
     */
    public static function fromString($string)
    {
        return new static(Uuid::fromString($string));
    }

    /**
     * Compares the object to another IdentifiesAggregate object. Returns true if both have the same type and value.
     * @param $other
     * @return boolean
     */
    public function equals(IdentifiesAggregate $other)
    {
        return $other instanceof static && $this->id == $other->id;
    }
}
