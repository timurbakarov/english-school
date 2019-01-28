<?php

namespace Domain\HumanResource\Student\Command;

use Domain\Date;
use Domain\Email;
use Domain\Phone;
use Domain\HumanResource\Student;
use Infr\Repository\GeneralRepository;
use Domain\HumanResource\Student\Name;
use Illuminate\Contracts\Events\Dispatcher;
use Domain\StudentId;
use Domain\Education\StudentGroup\StudentGroupId;

class AcceptStudentHandler
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
     * @param AcceptStudentCommand $command
     * @return StudentId
     * @throws \Domain\Exception\InvalidArgumentException
     */
    public function handle(AcceptStudentCommand $command)
    {
        $student = Student::accept(
            StudentId::generate(),
            StudentGroupId::fromString($command->groupId()),
            new Name($command->firstName(), $command->lastName()),
            $command->email() ? new Email($command->email()) : null,
            new Phone($command->phone()),
            Date::fromString($command->acceptedDate()),
            $command->parents()
        );

        $events = $student->getRecordedEvents();

        $this->repository->add($student);

        foreach($events as $event) {
            $this->eventDispatcher->dispatch($event);
        }

        return $student->id();
    }
}
