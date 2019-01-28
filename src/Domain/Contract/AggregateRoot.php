<?php

namespace Domain\Contract;

interface AggregateRoot extends RecordsEvents, IsEventSourced, TracksChanges
{

}
