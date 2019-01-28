<?php

namespace Domain\Education\Lesson\Command;

use Domain\Date;
use Domain\Exception\AggregateDoesNotExistException;
use Domain\Time;
use Domain\LessonId;
use Domain\Education\Lesson;
use Domain\Education\StudentGroup;
use Infr\Repository\GeneralRepository;
use Illuminate\Contracts\Events\Dispatcher;
use Domain\Education\StudentGroup\StudentGroupId;
use Domain\Education\StudentGroup\Schedule\GroupClassDuration;

class GiveLessonHandler
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
     * @param GiveLessonCommand $command
     * @return LessonId
     * @throws AggregateDoesNotExistException
     * @throws \Domain\Exception\InvalidArgumentException
     * @throws \Exception
     */
    public function handle(GiveLessonCommand $command)
    {
        $lessonId = LessonId::generate(Date::fromString($command->date()), Time::fromString($command->startTime()));

        try {
            $this->repository->get($lessonId);
        } catch (AggregateDoesNotExistException $e) {
            $studentGroupId = StudentGroupId::fromString($command->groupId());

            /** @var StudentGroup $group */
            $group = $this->repository->get($studentGroupId);

            $lesson = Lesson::give(
                $lessonId,
                $studentGroupId,
                Date::fromString($command->date()),
                Time::fromString($command->startTime()),
                $group->pricePerHour(),
                new GroupClassDuration($command->duration())
            );

            $events = $lesson->getRecordedEvents();

            $this->repository->add($lesson);

            foreach($events as $event) {
                $this->eventDispatcher->dispatch($event);
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return $lessonId;
    }
}
