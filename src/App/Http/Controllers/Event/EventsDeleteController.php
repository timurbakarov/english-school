<?php

namespace App\Http\Controllers\Event;

use Illuminate\Http\Request;
use Infr\Event\EventStoreModel;

class EventsDeleteController
{
    public function __invoke(string $id, EventStoreModel $eventStoreModel)
    {
        $eventStoreModel->where('id', $id)->delete();

        return redirect()->back();
    }

    public function massDelete(Request $request, EventStoreModel $eventStoreModel)
    {
        $ids = $request->post('ids');

        foreach($ids as $id) {
            $eventStoreModel->where('id', $id)->delete();
        }

        return ['success' => true];
    }
}
