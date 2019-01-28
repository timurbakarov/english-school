<?php

namespace Infr\Repository;

use Domain\Exception;
use Domain\Contract\EventStore;
use Domain\Contract\AggregateRoot;
use Domain\Contract\RecordsEvents;
use Domain\Contract\IsEventSourced;
use Domain\Contract\AggregateRepository;
use Domain\Contract\IdentifiesAggregate;

class GeneralRepository implements AggregateRepository
{
    /**
     * @var EventStore
     */
    private $eventStore;

    /**
     * @var RepositoryMapper
     */
    private $mapper;

    /**
     * @param EventStore $eventStore
     * @param RepositoryMapper $mapper
     */
    public function __construct(EventStore $eventStore, RepositoryMapper $mapper)
    {
        $this->eventStore = $eventStore;
        $this->mapper = $mapper;
    }

    /**
     * @param IdentifiesAggregate $aggregateId
     * @param string|null $context
     * @return IsEventSourced
     * @throws Exception\AggregateDoesNotExistException
     */
    public function get(IdentifiesAggregate $aggregateId, string $context = null)
    {
        $aggregateHistory = $this->eventStore->getAggregateHistoryFor($aggregateId);

        if($aggregateHistory->count() == 0) {
            throw new Exception\AggregateDoesNotExistException('Aggregate id [' . get_class($aggregateId) . '] ' . (string)$aggregateId);
        }

        /** @var AggregateRoot $aggregateClassName */
        $aggregateClassName = $this->mapper->map($aggregateId, $context);

        return $aggregateClassName::reconstituteFrom($aggregateHistory);
    }

    /**
     * @param RecordsEvents $aggregate
     * @return void
     */
    public function add(RecordsEvents $aggregate)
    {
        $events = $aggregate->getRecordedEvents();

        $aggregate->clearRecordedEvents();

        $this->eventStore->commit($events);
    }
}
