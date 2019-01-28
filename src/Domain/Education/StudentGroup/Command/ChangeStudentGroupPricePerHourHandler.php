<?php

namespace Domain\Education\StudentGroup\Command;

use Domain\Education\StudentGroup;
use Infr\Repository\GeneralRepository;
use Illuminate\Contracts\Events\Dispatcher;
use Domain\Education\StudentGroup\StudentGroupId;

class ChangeStudentGroupPricePerHourHandler
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

    public function handle(ChangeStudentGroupPricePerHourCommand $command)
    {
        /** @var StudentGroup $studentGroup */
        $studentGroup = $this->repository->get(StudentGroupId::fromString($command->studentGroupId()));

        $studentGroup->changePricePerHour(new StudentGroup\PricePerHour($command->pricePerHour()));

        $events = $studentGroup->getRecordedEvents();

        $this->repository->add($studentGroup);

        foreach($events as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}
