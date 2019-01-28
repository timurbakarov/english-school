<?php

namespace App\Http\Controllers;

use Domain\Command\FixStudent;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class StudentsUpdateController
{
    use ValidatesRequests;
    use DispatchesJobs;

    public function __invoke(string $id, Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        $this->dispatch(new FixStudent(
            $id,
            $request->post('first_name'),
            $request->post('last_name')
        ));

        return redirect('students');
    }
}
