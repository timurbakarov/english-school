<?php

namespace Domain;

trait AggregateRoot
{
    use RecordEventsTrait;
    use EventSourcedTrait;
}
