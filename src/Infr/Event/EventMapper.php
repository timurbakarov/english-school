<?php

namespace Infr\Event;

use Domain\Contract\DomainEvent;

class EventMapper
{
    /**
     * @var array
     */
    private $map;

    /**
     * @var
     */
    private $reverseMap;

    /**
     * @param array $map
     */
    public function __construct(array $map)
    {
        $this->map = $map;
        $this->reverseMap = array_flip($map);
    }

    /**
     * @param string $eventName
     * @return mixed
     * @throws \Exception
     */
    public function mapFromNameToClass(string $eventName)
    {
        if(!isset($this->map[$eventName])) {
            throw new \Exception(sprintf('Event [%s] does not exist', $eventName));
        }

        return $this->map[$eventName];
    }

    /**
     * @param DomainEvent $domainEvent
     * @return mixed
     * @throws \Exception
     */
    public function mapFromClassToName($domainEvent)
    {
        $className = $domainEvent instanceof $domainEvent ? get_class($domainEvent) : $domainEvent;

        if(!isset($this->reverseMap[$className])) {
            throw new \Exception(sprintf('Event with class name [%s] does not exist', $className));
        }

        return $this->reverseMap[$className];
    }

    /**
     * @param array $names
     * @return array
     */
    public function mapManyFromNameToClass(array $names)
    {
        return array_map(function($name) {
            return $this->mapFromNameToClass($name);
        }, $names);
    }

    /**
     * @param array $events
     * @return array
     */
    public function mapManyFromClassToName(array $events)
    {
        return array_map(function($event) {
            return $this->mapFromClassToName($event);
        }, $events);
    }
}
