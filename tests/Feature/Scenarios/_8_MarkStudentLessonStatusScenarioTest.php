<?php

namespace Tests\Feature\Scenarios;

use Domain\Date;
use Domain\DomainEvents;
use Domain\Education\Lesson\Event\LessonWasGiven;
use Domain\Education\Lesson\Exception\StudentWasAlreadyMarkedException;
use Domain\Education\StudentGroup\StudentGroupId;
use Domain\HumanResource\Student\Event\StudentWasAccepted;
use Domain\LessonId;
use Domain\StudentId;
use Domain\Time;
use Infr\TestServices;
use PHPUnit\Framework\TestCase;
use Domain\Education\Lesson\Event\StudentMissedLesson;
use Domain\Education\Lesson\Event\StudentAttendedLesson;
use Domain\Education\Lesson\Command\MarkStudentLessonStatusCommand;
use Domain\Education\Lesson\Command\MarkStudentLessonStatusHandler;

class _8_MarkStudentLessonStatusScenarioTest extends TestCase
{
    public function test_student_attend_lesson()
    {
        $testServices = new TestServices();

        $lessonId = LessonId::generate();
        $studentId = StudentId::generate();

        $testServices->eventStore()->commit(new DomainEvents([
            StudentWasAccepted::forTest($studentId),
            LessonWasGiven::forTest($lessonId)
        ]));

        $command = new MarkStudentLessonStatusCommand((string)$lessonId, (string)$studentId, 'attended');
        $handler = new MarkStudentLessonStatusHandler(
            $testServices->repository(),
            $testServices->eventDispatcher()
        );

        $handler->handle($command);

        $aggregateHistory = $testServices->eventStore()->getAggregateHistoryFor($lessonId);

        /** @var StudentAttendedLesson $event */
        $event = $aggregateHistory[1];

        $this->assertEquals(2, count($aggregateHistory));
        $this->assertEquals(1, $testServices->eventDispatcher()->count());
        $this->assertInstanceOf(StudentAttendedLesson::class, $event);
        $this->assertEquals((string)$lessonId, $event->getAggregateId());
        $this->assertEquals([
            'student_id' => (string)$studentId,
        ], $event->data());
    }

    public function test_student_miss_lesson()
    {
        $testServices = new TestServices();

        $lessonId = LessonId::generate();
        $studentId = StudentId::generate();

        $testServices->eventStore()->commit(new DomainEvents([
            StudentWasAccepted::forTest($studentId),
            LessonWasGiven::forTest($lessonId)
        ]));

        $command = new MarkStudentLessonStatusCommand((string)$lessonId, (string)$studentId, 'missed');
        $handler = new MarkStudentLessonStatusHandler(
            $testServices->repository(),
            $testServices->eventDispatcher()
        );

        $handler->handle($command);

        $aggregateHistory = $testServices->eventStore()->getAggregateHistoryFor($lessonId);

        /** @var StudentMissedLesson $event */
        $event = $aggregateHistory[1];

        $this->assertEquals(2, count($aggregateHistory));
        $this->assertEquals(1, $testServices->eventDispatcher()->count());
        $this->assertInstanceOf(StudentMissedLesson::class, $event);
        $this->assertEquals((string)$lessonId, $event->getAggregateId());
        $this->assertEquals([
            'student_id' => (string)$studentId,
        ], $event->data());
    }

    public function test_throw_exception_if_student_already_marked()
    {
        $this->expectException(StudentWasAlreadyMarkedException::class);

        $testServices = new TestServices();

        $lessonId = LessonId::generate();
        $studentId = StudentId::generate();

        $testServices->eventStore()->commit(new DomainEvents([
            StudentWasAccepted::forTest($studentId),
            LessonWasGiven::forTest($lessonId)
        ]));

        $testServices->eventStore()->commit(new DomainEvents([
            new StudentAttendedLesson(
                $lessonId,
                $studentId
            )
        ]));

        $command = new MarkStudentLessonStatusCommand((string)$lessonId, (string)$studentId, 'attended');
        $handler = new MarkStudentLessonStatusHandler(
            $testServices->repository(),
            $testServices->eventDispatcher()
        );

        $handler->handle($command);
    }
}
