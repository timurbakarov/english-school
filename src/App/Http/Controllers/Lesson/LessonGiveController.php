<?php

namespace App\Http\Controllers\Lesson;

use Illuminate\Http\Request;
use Domain\Contract\CommandBus;
use Domain\Education\Lesson\Command\GiveLessonCommand;
use Domain\Education\Lesson\Command\MarkStudentLessonStatusCommand;

class LessonGiveController
{
    public function __invoke(Request $request, CommandBus $commandBus)
    {
        $lessonId = $commandBus->dispatch(new GiveLessonCommand(
            $request->post('group_id'),
            $request->post('date'),
            $request->post('time'),
            $request->post('duration')
        ));

        $commandBus->dispatch(new MarkStudentLessonStatusCommand(
            (string)$lessonId,
            $request->post('student_id'),
            $request->post('status')
        ));

        return redirect()->back();
    }
}
