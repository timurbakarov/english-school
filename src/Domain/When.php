<?php

namespace Domain;

use Domain\Contract\DomainEvent;

trait When
{
    protected function when(DomainEvent $event)
    {
        $segments = explode('\\', get_class($event));

        $method = 'when' . end($segments);

        if(method_exists($this, $method)) {
            $this->$method($event);
        }
    }
}
