<?php

namespace Presentation;

use Presentation\Schedule\ScheduleItemPresentation;

class ScheduleCompact
{
    /**
     * @var
     */
    private $schedule;

    /**
     * @param $schedules
     */
    public function __construct($schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * @return mixed
     */
    public function schedule()
    {
        return $this->schedule->map(function($schedule) {
            return app(ScheduleItemPresentation::class)->display($schedule);
        });
    }
}
