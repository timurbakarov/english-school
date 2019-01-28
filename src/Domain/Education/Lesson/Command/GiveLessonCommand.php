<?php

namespace Domain\Education\Lesson\Command;

class GiveLessonCommand
{
    /**
     * @var string
     */
    private $groupId;

    /**
     * @var string
     */
    private $date;

    /**
     * @var string
     */
    private $startTime;

    /**
     * @var int
     */
    private $duration;

    /**
     * @param string $groupId
     * @param string $date
     * @param string $startTime
     * @param int $duration
     */
    public function __construct(string $groupId, string $date, string $startTime, int $duration)
    {
        $this->groupId = $groupId;
        $this->date = $date;
        $this->startTime = $startTime;
        $this->duration = $duration;
    }

    /**
     * @return string
     */
    public function groupId(): string
    {
        return $this->groupId;
    }

    /**
     * @return string
     */
    public function date(): string
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function startTime(): string
    {
        return $this->startTime;
    }

    /**
     * @return int
     */
    public function duration(): int
    {
        return $this->duration;
    }
}
