<?php

namespace Domain\HumanResource\Student\Command;

use Domain\Date;
use Domain\StudentId;
use Domain\HumanResource\Student;
use Infr\Repository\GeneralRepository;
use Illuminate\Contracts\Events\Dispatcher;
use Domain\Education\StudentGroup\StudentGroupId;
use Domain\Education\StudentGroup\Specification\StudentGroupAssignableSpec;

class MoveStudentToAnotherGroupHandler
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
     * @var StudentGroupAssignableSpec
     */
    private $studentGroupAssignableSpec;

    /**
     * @param GeneralRepository $repository
     * @param Dispatcher $eventDispatcher
     * @param StudentGroupAssignableSpec $studentGroupAssignableSpec
     */
    public function __construct(
        GeneralRepository $repository,
        Dispatcher $eventDispatcher,
        StudentGroupAssignableSpec $studentGroupAssignableSpec
    ) {
        $this->repository = $repository;
        $this->eventDispatcher = $eventDispatcher;
        $this->studentGroupAssignableSpec = $studentGroupAssignableSpec;
    }

    public function handle(MoveStudentToAnotherGroupCommand $command)
    {
        /** @var Student $student */
        $student = $this->repository->get(StudentId::fromString($command->studentId()), 'human_resource');

        $movedDate = $command->movedDate() ? Date::fromString($command->movedDate()) : null;

        $student->assignToAnotherGroup(
            StudentGroupId::fromString($command->groupId()),
            $movedDate,
            $this->studentGroupAssignableSpec
        );

        $events = $student->getRecordedEvents();

        $this->repository->add($student);

        foreach($events as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}
