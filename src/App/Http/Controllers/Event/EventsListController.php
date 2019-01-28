<?php

namespace App\Http\Controllers\Event;

use Illuminate\Http\Request;
use Infr\Event\EventStoreModel;

class EventsListController
{
    public function __invoke(Request $request, EventStoreModel $eventStoreModel)
    {
        $search = $request->get('search');

        $query = $eventStoreModel
            ->orderBy('event_timestamp', 'DESC');

        if($search) {
            $query->where('aggregate_id', $search);
            $query->orWhere('event_name', $search);
        }

        $events = $query->get();

        return view('events.list', [
            'search' => $search,
            'events' => $events->map(function($event) {
                return [
                    'id' => $event->id,
                    'aggregate_id' => $event->aggregate_id,
                    'name' => $event->event_name,
                    'date' => date('d.m.Y H:i:s', $event->event_timestamp),
                    'payload' => json_decode($event->payload),
                    'delete_url' => url('events/delete', $event->id),
                ];
            }),
        ]);
    }
}
