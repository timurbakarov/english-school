<?php

namespace App\Http\Controllers\Group;

use Illuminate\Http\Request;
use Domain\Contract\CommandBus;
use Domain\Education\StudentGroup\Command\ChangeStudentGroupNameCommand;
use Domain\Education\StudentGroup\Command\ChangeStudentGroupScheduleCommand;
use Domain\Education\StudentGroup\Command\ChangeStudentGroupPricePerHourCommand;

class UpdateGroupController
{
    public function __invoke(string $id, Request $request, CommandBus $commandBus)
    {
        $commandBus->dispatch(new ChangeStudentGroupNameCommand($id, $request->post('name')));

        $commandBus->dispatch(new ChangeStudentGroupPricePerHourCommand($id, $request->post('price_per_hour')));

        $commandBus->dispatch(new ChangeStudentGroupScheduleCommand($id, $request->post('schedule')));

        return redirect('groups');
    }
}
