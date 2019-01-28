<?php

namespace Domain\Education\StudentGroup\Command;

use Domain\Date;
use Domain\Education\StudentGroup;
use Infr\Repository\GeneralRepository;
use Illuminate\Contracts\Events\Dispatcher;
use Domain\Education\StudentGroup\StudentGroupId;

class ChangeStudentGroupNameHandler
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

    public function handle(ChangeStudentGroupNameCommand $command)
    {
        /** @var StudentGroup $studentGroup */
        $studentGroup = $this->repository->get(StudentGroupId::fromString($command->studentGroupId()));

        $studentGroup->changeName(
            new StudentGroup\StudentGroupName($command->name()),
            $command->changedOn() ? Date::fromString($command->changedOn()) : null
        );

        $events = $studentGroup->getRecordedEvents();

        $this->repository->add($studentGroup);

        foreach($events as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}
