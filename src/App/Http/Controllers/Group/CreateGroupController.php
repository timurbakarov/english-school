<?php

namespace App\Http\Controllers\Group;

use Api\Api;
use App\FormRequest\GroupCreateFormRequest;

class CreateGroupController
{
    public function __invoke(GroupCreateFormRequest $request, Api $api)
    {
        $api->studentsGroups()->createGroup(
            $request->post('name'),
            $request->post('schedule'),
            $request->post('price_per_hour'),
            $request->post('created_date')
        );

        return redirect(action(GroupListController::class));
    }
}
