<?php

namespace Domain\StudyClass;

use Carbon\Carbon;

class StudyDate
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
     * @return Carbon
     */
    public function value()
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->date->format('Y-m-d');
    }
}
