<?php

namespace Domain\Education\StudentGroup\Command;

use Illuminate\Http\Request;

class CreateStudentGroupCommand
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $schedule;

    /**
     * @var int
     */
    private $pricePerHour;

    /**
     * @var string
     */
    private $createdDate;

    /**
     * @param string $name
     * @param string $schedule
     * @param int $pricePerHour
     * @param string $createdDate
     */
    public function __construct(string $name, string $schedule, int $pricePerHour, string $createdDate)
    {
        $this->name = $name;
        $this->schedule = $schedule;
        $this->pricePerHour = $pricePerHour;
        $this->createdDate = $createdDate;
    }

    /**
     * @param Request $request
     * @return CreateStudentGroupCommand
     */
    public static function fromRequest(Request $request)
    {
        return new self(
            $request->post('name'),
            $request->post('schedule'),
            $request->post('price_per_hour'),
            $request->post('created_date')
        );
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function schedule(): string
    {
        return $this->schedule;
    }

    /**
     * @return int
     */
    public function pricePerHour(): int
    {
        return $this->pricePerHour;
    }

    /**
     * @return string
     */
    public function createdDate(): string
    {
        return $this->createdDate;
    }
}
