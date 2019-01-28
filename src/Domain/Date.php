<?php

namespace Domain;

use Carbon\Carbon;

class Date
{
    /**
     * @var Carbon
     */
    private $date;

    /**
     * PaymentDate constructor.
     * @param Carbon $date
     */
    public function __construct(Carbon $date)
    {
        $this->date = $date;
    }

    /**
     * @param string $date
     * @return Date
     */
    public static function fromString(string $date)
    {
        return new self(new Carbon($date));
    }

    /**
     * @return Carbon
     */
    public function value()
    {
        return clone $this->date;
    }

    /**
     * @return Date
     */
    public static function now()
    {
        return new self(new Carbon());
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->date->format('Y-m-d');
    }

    /**
     * @param Date $date
     * @return bool
     */
    public function equals(Date $date)
    {
        return (string)$this == (string)$date;
    }

    /**
     * @param Date $date
     * @return bool
     */
    public function isGreater(Date $date)
    {
        $current = (new \DateTime((string)$this . ' 00:00:00'))->getTimestamp();
        $compare = (new \DateTime((string)$date . ' 00:00:00'))->getTimestamp();

        return $current > $compare;
    }

    /**
     * @param Date $date
     * @return bool
     */
    public function isLower(Date $date)
    {
        $current = (new \DateTime((string)$this . ' 00:00:00'))->getTimestamp();
        $compare = (new \DateTime((string)$date . ' 00:00:00'))->getTimestamp();

        return $current < $compare;
    }

    /**
     * @param Date $date
     * @return bool
     */
    public function isLowerOrEqual(Date $date)
    {
        return $this->isLower($date) || $this->equals($date);
    }

    /**
     * @param Date $date
     * @return bool
     */
    public function isGreaterOrEqual(Date $date)
    {
        return $this->isGreater($date) || $this->equals($date);
    }
}
