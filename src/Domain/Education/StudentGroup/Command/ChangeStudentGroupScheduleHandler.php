<?php

namespace Domain\Education\StudentGroup\Command;

use Domain\Education\StudentGroup;
use Infr\Repository\GeneralRepository;
use Illuminate\Contracts\Events\Dispatcher;
use Domain\Education\StudentGroup\StudentGroupId;

class ChangeStudentGroupScheduleHandler
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

    public function handle(ChangeStudentGroupScheduleCommand $command)
    {
        /** @var StudentGroup $group */
        $group = $this->repository->get(StudentGroupId::fromString($command->studentGroupId()));

        $group->changeSchedule(StudentGroup\Schedule::fromString($command->schedule()));

        $events = $group->getRecordedEvents();

        $this->repository->add($group);

        foreach($events as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}
