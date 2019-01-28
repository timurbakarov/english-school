<?php

namespace Domain\Education\StudentGroup\Command;

use Domain\Date;
use Domain\Education\StudentGroup;
use Infr\Repository\GeneralRepository;
use Illuminate\Contracts\Events\Dispatcher;
use Domain\Education\StudentGroup\StudentGroupId;

class CreateStudentGroupHandler
{
    /**
     * @var GeneralRepository
     */
    private $repository;

    /**
     * @var Dispatcher
     */
    private $eventDispatcher;

    /**
     * @param GeneralRepository $repository
     * @param Dispatcher $eventDispatcher
     */
    public function __construct(GeneralRepository $repository, Dispatcher $eventDispatcher)
    {
        $this->repository = $repository;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param CreateStudentGroupCommand $command
     * @return StudentGroupId
     * @throws \Domain\Exception\InvalidArgumentException
     */
    public function handle(CreateStudentGroupCommand $command)
    {
        $studentGroupId = StudentGroupId::generate();

        $studentGroup = StudentGroup::create(
            $studentGroupId,
            StudentGroup\Schedule::fromString($command->schedule()),
            new StudentGroup\StudentGroupName($command->name()),
            new StudentGroup\PricePerHour($command->pricePerHour()),
            Date::fromString($command->createdDate())
        );

        $events = $studentGroup->getRecordedEvents();

        $this->repository->add($studentGroup);

        foreach($events as $event) {
            $this->eventDispatcher->dispatch($event);
        }

        return $studentGroupId;
    }
}
