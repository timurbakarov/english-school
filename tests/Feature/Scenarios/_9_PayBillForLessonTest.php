<?php

namespace Tests\Feature\Scenarios;

use Domain\Date;
use Domain\Time;
use Domain\LessonId;
use Domain\StudentId;
use Infr\TestServices;
use Domain\DomainEvents;
use PHPUnit\Framework\TestCase;
use Domain\Finance\Student\PaymentId;
use Domain\Finance\Student\PaymentType;
use Domain\Finance\Student\PaymentAmount;
use Domain\Education\StudentGroup\PricePerHour;
use Domain\Education\Lesson\Event\LessonWasGiven;
use Domain\Education\StudentGroup\StudentGroupId;
use Domain\Finance\Student\Event\StudentMadePayment;
use Domain\Finance\Student\Event\StudentPaidForLesson;
use Domain\Finance\Student\Event\StudentGotDebtForLesson;
use Domain\HumanResource\Student\Event\StudentWasAccepted;
use Domain\Finance\Student\Command\PayBillForLessonCommand;
use Domain\Finance\Student\Command\PayBillForLessonHandler;
use Domain\Education\StudentGroup\Schedule\GroupClassDuration;

class _9_PayBillForLessonTest extends TestCase
{
    public function test_student_pay_for_lesson()
    {
        $testServices = new TestServices();

        $lessonId = LessonId::generate();
        $studentId = StudentId::generate();
        $studentGroupId = StudentGroupId::generate();

        $testServices->eventStore()->commit(new DomainEvents([
            new LessonWasGiven(
                $lessonId,
                $studentGroupId,
                Date::fromString('2018-10-12'),
                new Time(10, 30),
                new PricePerHour(300),
                new GroupClassDuration(2)
            ),
            new StudentMadePayment(
                $studentId,
                PaymentId::generate(),
                new PaymentAmount(1000),
                PaymentType::cash(),
                Date::now()
            )
        ]));

        $command = new PayBillForLessonCommand((string)$studentId, (string)$lessonId);
        $handler = new PayBillForLessonHandler(
            $testServices->repository(),
            $testServices->eventDispatcher()
        );

        $handler->handle($command);

        $aggregateHistory = $testServices->eventStore()->getAggregateHistoryFor($studentId);

        /** @var StudentPaidForLesson $event */
        $event = $aggregateHistory[1];

        $this->assertEquals(2, count($aggregateHistory));
        $this->assertEquals(1, $testServices->eventDispatcher()->count());
        $this->assertInstanceOf(StudentPaidForLesson::class, $event);
        $this->assertEquals((string)$studentId, $event->getAggregateId());
        $this->assertEquals([
            'lesson_id' => (string)$lessonId,
            'amount' => '600',
            'payed_on' => '2018-10-12',
        ], $event->data());
    }

    public function test_student_get_debt_for_lesson()
    {
        $testServices = new TestServices();

        $lessonId = LessonId::generate();
        $studentId = StudentId::generate();
        $studentGroupId = StudentGroupId::generate();

        $testServices->eventStore()->commit(new DomainEvents([
            StudentWasAccepted::forTest($studentId),
            LessonWasGiven::forTest($lessonId)
        ]));

        $testServices->eventStore()->commit(new DomainEvents([
            new LessonWasGiven(
                $lessonId,
                $studentGroupId,
                Date::fromString('2018-10-12'),
                new Time(10, 30),
                new PricePerHour(300),
                new GroupClassDuration(2)
            )
        ]));

        $command = new PayBillForLessonCommand((string)$studentId, (string)$lessonId);
        $handler = new PayBillForLessonHandler(
            $testServices->repository(),
            $testServices->eventDispatcher()
        );

        $handler->handle($command);

        $aggregateHistory = $testServices->eventStore()->getAggregateHistoryFor($studentId);

        /** @var StudentGotDebtForLesson $event */
        $event = $aggregateHistory[1];

        $this->assertEquals(2, count($aggregateHistory));
        $this->assertEquals(1, $testServices->eventDispatcher()->count());
        $this->assertInstanceOf(StudentGotDebtForLesson::class, $event);
        $this->assertEquals((string)$studentId, $event->getAggregateId());
        $this->assertEquals([
            'lesson_id' => (string)$lessonId,
            'amount' => '600',
            'got_debt_on' => '2018-10-12',
        ], $event->data());
    }
}
