<?php

namespace Domain;

abstract class BaseProjection
{
    /**
     * @return array
     */
    public abstract function events() : array;

    /**
     * @return mixed
     */
    public abstract function readModel();

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    final public function subscribe($events)
    {
        foreach($this->events() as $event) {
            $segments = explode('\\', $event);
            $eventName = end($segments);

            $events->listen(
                $event,
                get_class($this) . '@when' . $eventName
            );
        }
    }
}
