<?php

namespace Infr\EventStore;

use Domain\AggregateHistory;
use Domain\Contract\DomainEvent;
use Domain\Contract\EventStore;
use Domain\Contract\IdentifiesAggregate;
use Domain\DomainEvents;

class InMemoryEventStore implements EventStore
{
    /**
     * @var array
     */
    private $events = [];

    /**
     * @param DomainEvents $events
     * @return void
     */
    public function commit(DomainEvents $events)
    {
        /** @var DomainEvent $event */
        foreach ($events as $event) {
            $this->events[] = [
                'aggregate_id' => (string)$event->getAggregateId(),
                'event_name' => get_class($event),
                'payload' => json_encode($event->data()),
            ];
        }
    }

    /**
     * @param IdentifiesAggregate $id
     * @return AggregateHistory
     * @throws \Domain\Exception\CorruptAggregateHistory
     */
    public function getAggregateHistoryFor(IdentifiesAggregate $id)
    {
        $events = array_filter($this->events, function($event) use($id) {
            return $event['aggregate_id'] == $id;
        });

        return new AggregateHistory($id, array_map(function($data) {
            $eventClass = $data['event_name'];
            $payload = json_decode($data['payload']);
            $payload->aggregate_id = $data['aggregate_id'];

            return $eventClass::rebuildFromData($payload);
        }, $events));
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->events);
    }

    /**
     * @param $event
     * @return mixed
     */
    public function byEvents(array $event)
    {

    }
}
