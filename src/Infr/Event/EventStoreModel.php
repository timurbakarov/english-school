<?php

namespace Infr\Event;

use Illuminate\Database\Eloquent\Model;

class EventStoreModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'event_store';

    /**
     * @var bool
     */
    public $timestamps = false;
}
