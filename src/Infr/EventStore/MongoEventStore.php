<?php

namespace Infr\EventStore;

use MongoDB\Database;
use Domain\DomainEvents;
use Domain\AggregateHistory;
use Domain\Contract\EventStore;
use Domain\Contract\DomainEvent;
use Domain\Contract\IdentifiesAggregate;

class MongoEventStore implements EventStore
{
    /**
     * @var \MongoDB\Collection
     */
    private $collection;

    /**
     * MongoEventStore constructor.
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->collection = $database->events_store;
    }

    /**
     * @param DomainEvents $events
     * @return void
     */
    public function commit(DomainEvents $events)
    {
        /** @var \Domain\DomainEvent $event */
        foreach ($events as $event) {
            $data = array_merge([
                'aggregate_id' => (string)$event->getAggregateId(),
                'event' => get_class($event),
                'event_timestamp' => $event->createdAt(),
            ], $event->data());

            $this->collection->insertOne($data);
        }
    }

    /**
     * @param IdentifiesAggregate $id
     * @return AggregateHistory
     * @throws \Domain\Exception\CorruptAggregateHistory
     */
    public function getAggregateHistoryFor(IdentifiesAggregate $id)
    {
        $docs = $this->collection->find(['aggregate_id' => (string)$id]);

        $events = [];

        foreach($docs as $doc) {
            /** @var DomainEvent $eventClass */
            $eventClass = $doc->event;

            $events[] = $eventClass::rebuildFromData($doc);
        }

        return new AggregateHistory($id, $events);
    }

    /**
     * @param array $events
     * @return array|mixed
     */
    public function byEvents(array $events)
    {
        $docs = $this->collection->find(['event' => ['$in' => $events]]);

        $events = [];

        foreach($docs as $doc) {
            /** @var DomainEvent $eventClass */
            $eventClass = $doc->event;

            $events[] = $eventClass::rebuildFromData($doc);
        }

        return $events;
    }
}
