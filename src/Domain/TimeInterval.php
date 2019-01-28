<?php

namespace Domain;

use Domain\Exception\InvalidArgumentException;

class TimeInterval
{
    const STUDY_CLASS_REAL_TIME_DURATION = 45;
    const STUDY_CLASS_PAUSE_DURATION = 15;

    /**
     * @var Time
     */
    private $beginTime;

    /**
     * @var array
     */
    private $endTime;

    /**
     * TimeInterval constructor.
     * @param Time $beginTime
     * @param Time $endTime
     * @throws InvalidArgumentException
     */
    public function __construct(Time $beginTime, Time $endTime)
    {
        if($endTime->convertToMinutes() <= $beginTime->convertToMinutes()) {
            throw new InvalidArgumentException("End time can not be earlier than begin time");
        }

        $this->beginTime = $beginTime;
        $this->endTime = $endTime;
    }

    /**
     * @return Time
     */
    public function beginTime()
    {
        return $this->beginTime;
    }

    /**
     * @return Time
     */
    public function endTime()
    {
        return $this->endTime;
    }

    /**
     * @param Time $time
     * @param int $educationalDuration
     * @return TimeInterval
     * @throws InvalidArgumentException
     */
    public static function fromTimeAndDuration(Time $time, int $educationalDuration)
    {
        if($educationalDuration < 1) {
            throw new InvalidArgumentException("Duration should be more than 1");
        }

        return new self(
            $time,
            self::calculateEndTime($time, self::convertEducationToRealTimeDuration($educationalDuration))
        );
    }

    /**
     * @param string $formattedTimeInterval
     * @return TimeInterval
     * @throws InvalidArgumentException
     */
    public static function fromFormattedTimeInterval(string $formattedTimeInterval)
    {
        list($beginTime, $endTime) = explode(' - ', $formattedTimeInterval);

        return new self(Time::fromString($beginTime), Time::fromString($endTime));
    }

    /**
     * @return string
     */
    public function formattedTimeInterval()
    {
        return sprintf('%s - %s', (string)$this->beginTime, (string)$this->endTime);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->formattedTimeInterval();
    }

    /**
     * @param $educationalDuration
     * @return float|int
     */
    public static function convertEducationToRealTimeDuration($educationalDuration)
    {
        return $educationalDuration * self::STUDY_CLASS_REAL_TIME_DURATION;
    }

    /**
     * @param Time $time
     * @param int $duration
     * @return Time
     * @throws InvalidArgumentException
     */
    public static function calculateEndTime(Time $time, int $duration)
    {
        if($time->minutes() + $duration > 59) {
            $hour = $time->hour() + floor(($time->minutes() + $duration)/60);
            $minutes = ($time->minutes() + $duration)%60;
        } else {
            $minutes = $time->minutes() + $duration;
            $hour = $time->hour();
        }

        return new Time($hour, $minutes);
    }

    /**
     * @param TimeInterval $timeInterval
     * @return bool
     */
    public function isOverlapped(TimeInterval $timeInterval)
    {
        if($this->beginTime->convertToMinutes() > $timeInterval->endTime->convertToMinutes()) {
            return false;
        }

        if($this->endTime->convertToMinutes() < $timeInterval->beginTime->convertToMinutes()) {
            return false;
        }

        return true;
    }

    /**
     * @param TimeInterval $timeInterval
     * @return bool
     */
    public function equals(TimeInterval $timeInterval)
    {
        return $this->beginTime->convertToMinutes() == $timeInterval->beginTime()->convertToMinutes()
            && $this->endTime->convertToMinutes() == $timeInterval->endTime()->convertToMinutes();
    }
}
