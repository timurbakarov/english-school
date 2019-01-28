<?php

namespace Tests\Feature\Scenarios;

use Domain\DomainEvents;
use Domain\StudentId;
use Infr\TestServices;
use PHPUnit\Framework\TestCase;
use Domain\Finance\Student\Event\StudentMadePayment;
use Domain\HumanResource\Student\Event\StudentWasAccepted;
use Domain\Finance\Student\Command\MakeStudentPaymentCommand;
use Domain\Finance\Student\Command\MakeStudentPaymentHandler;

class _5_StudentMakePaymentScenarioTest extends TestCase
{
    public function test_make_payment()
    {
        $testServices = new TestServices();

        $studentId = StudentId::generate();

        $testServices->eventStore()->commit(new DomainEvents([
            StudentWasAccepted::forTest($studentId)
        ]));

        $command = new MakeStudentPaymentCommand((string)$studentId, 500, 'cash', '2018-10-12');
        $handler = new MakeStudentPaymentHandler(
            $testServices->repository(),
            $testServices->eventDispatcher()
        );

        $handler->handle($command);

        $aggregateHistory = $testServices->eventStore()->getAggregateHistoryFor($studentId);

        /** @var StudentMadePayment $event */
        $event = $aggregateHistory[1];

        $this->assertEquals(2, count($aggregateHistory));
        $this->assertEquals(1, $testServices->eventDispatcher()->count());
        $this->assertInstanceOf(StudentMadePayment::class, $event);
        $this->assertEquals($studentId->toString(), $event->getAggregateId());
        $this->assertEquals([
            'payment_id' => (string)$event->paymentId(),
            'amount' => '500',
            'type' => 'cash',
            'payed_on' => '2018-10-12',
        ], $event->data());
    }
}
