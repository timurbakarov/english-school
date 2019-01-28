<?php

namespace App\Http\Controllers\Group;

use App\PageData\Group\GroupsListDataProvider;

class GroupListController
{
    public function __invoke(GroupsListDataProvider $groupsListDataProvider)
    {
        return view('groups.list', $groupsListDataProvider->provide());
    }
}
