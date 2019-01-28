<?php

namespace Infr\EventStore;

use Domain\DomainEvents;
use Infr\Event\EventMapper;
use Domain\AggregateHistory;
use Domain\Contract\EventStore;
use Infr\Event\EventStoreModel;
use Domain\Contract\DomainEvent;
use Domain\Contract\IdentifiesAggregate;

class EloquentEventStore implements EventStore
{
    /**
     * @var EventStoreModel
     */
    private $eventStoreModel;

    /**
     * @var EventMapper
     */
    private $eventMapper;

    /**
     * @param EventStoreModel $eventStoreModel
     * @param EventMapper $eventMapper
     */
    public function __construct(EventStoreModel $eventStoreModel, EventMapper $eventMapper)
    {
        $this->eventStoreModel = $eventStoreModel;
        $this->eventMapper = $eventMapper;
    }

    /**
     * @param EventMapper $eventMapper
     */
    public function setEventMapper(EventMapper $eventMapper)
    {
        $this->eventMapper = $eventMapper;
    }

    /**
     * @param DomainEvents $events
     * @throws \Throwable
     */
    public function commit(DomainEvents $events)
    {
        /** @var \Domain\DomainEvent $event */
        foreach ($events as $event) {
            $record = $this->eventStoreModel->newInstance();

            $record->aggregate_id = (string)$event->getAggregateId();
            $record->event_name = $this->eventMapper->mapFromClassToName($event);
            $record->event_timestamp = $event->createdAt();
            $record->payload = json_encode($event->data());

            $record->saveOrFail();
        }
    }

    /**
     * @param IdentifiesAggregate $id
     * @return AggregateHistory
     * @throws \Domain\Exception\CorruptAggregateHistory
     * @throws \Exception
     */
    public function getAggregateHistoryFor(IdentifiesAggregate $id)
    {
        $rows = $this->eventStoreModel->where('aggregate_id', (string)$id)->get();

        $events = [];

        foreach($rows as $row) {
            /** @var DomainEvent $eventClass */
            $eventClass = $this->eventMapper->mapFromNameToClass($row->event_name);

            $payload = json_decode($row->payload);
            $payload->aggregate_id = $row->aggregate_id;

            $events[] = $eventClass::rebuildFromData($payload);
        }

        return new AggregateHistory($id, $events);
    }

    /**
     * @param array $events
     * @return array|mixed
     * @throws \Exception
     */
    public function byEvents(array $events)
    {
        $rows = $this->eventStoreModel->whereIn('event_name', $events)->get();

        $events = [];

        foreach($rows as $row) {
            /** @var DomainEvent $eventClass */
            $eventClass = $this->eventMapper->mapFromNameToClass($row->event_name);

            $payload = json_decode($row->payload);
            $payload->aggregate_id = $row->aggregate_id;

            $events[] = $eventClass::rebuildFromData($payload);
        }

        return $events;
    }
}
