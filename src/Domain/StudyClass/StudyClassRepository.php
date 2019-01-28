<?php

namespace Domain\Student;

use Domain\Contract\EventStore;
use Domain\Contract\AggregateRepository;
use Domain\Contract\IdentifiesAggregate;
use Domain\Contract\IsEventSourced;
use Domain\Contract\RecordsEvents;
use Domain\StudyClass;

class StudyClassRepository implements AggregateRepository
{
    /**
     * @var EventStore
     */
    private $eventStore;

    /**
     * StudentRepository constructor.
     * @param EventStore $eventStore
     */
    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    /**
     * @param IdentifiesAggregate $aggregateId
     * @return IsEventSourced|StudyClass
     */
    public function get(IdentifiesAggregate $aggregateId)
    {
        $aggregateHistory = $this->eventStore->getAggregateHistoryFor($aggregateId);

        return StudyClass::reconstituteFrom($aggregateHistory);
    }

    /**
     * @param RecordsEvents $aggregate
     * @return void
     */
    public function add(RecordsEvents $aggregate)
    {
        $events = $aggregate->getRecordedEvents();

        $this->eventStore->commit($events);
    }
}
