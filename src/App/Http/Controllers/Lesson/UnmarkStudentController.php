<?php

namespace App\Http\Controllers\Lesson;

use Domain\Contract\CommandBus;
use Domain\Education\Lesson\Command\UnmarkStudentLessonStatusCommand;

class UnmarkStudentController
{
    public function __invoke(string $studentId, string $lessonId, CommandBus $commandBus)
    {
        $commandBus->dispatch(new UnmarkStudentLessonStatusCommand($lessonId, $studentId));

        return redirect()->back();
    }
}
