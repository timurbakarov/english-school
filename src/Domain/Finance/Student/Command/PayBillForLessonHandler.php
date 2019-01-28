<?php

namespace Domain\Finance\Student\Command;

use Domain\LessonId;
use Domain\StudentId;
use Domain\Finance\Student;
use Domain\Education\Lesson;
use Infr\Repository\GeneralRepository;
use Illuminate\Contracts\Events\Dispatcher;

class PayBillForLessonHandler
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

    public function handle(PayBillForLessonCommand $command)
    {
        /** @var Lesson $lesson */
        $lesson = $this->repository->get(LessonId::fromString($command->lessonId()));

        /** @var Student $student */
        $student = $this->repository->get(StudentId::fromString($command->studentId()), 'finance');

        $student->payForLesson($lesson);

        $events = $student->getRecordedEvents();

        $this->repository->add($student);

        foreach($events as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}
