<?php

return [
    'map' => [
    // Education
        // groups
        'StudentGroupWasCreated' => Domain\Education\StudentGroup\Event\StudentGroupWasCreated::class,
        'StudentGroupScheduleWasChanged' => \Domain\Education\StudentGroup\Event\StudentGroupScheduleWasChanged::class,
        'StudentGroupNameWasChanged' => \Domain\Education\StudentGroup\Event\StudentGroupNameWasChanged::class,
        'StudentGroupPricePerHourWasChanged' => \Domain\Education\StudentGroup\Event\StudentGroupPricePerHourWasChanged::class,

        'LessonWasGiven' => \Domain\Education\Lesson\Event\LessonWasGiven::class,
        'StudentAttendedLesson' => \Domain\Education\Lesson\Event\StudentAttendedLesson::class,
        'StudentMissedLesson' => \Domain\Education\Lesson\Event\StudentMissedLesson::class,
        'StudentMissedLessonWasUnmarked' => \Domain\Education\Lesson\Event\StudentMissedLessonWasUnmarked::class,

    // Human Resource
        // students
        'StudentWasAccepted' => \Domain\HumanResource\Student\Event\StudentWasAccepted::class,
        'StudentWasDismissed' => \Domain\HumanResource\Student\Event\StudentWasDismissed::class,
        'StudentWasAssignedToAnotherGroup' => \Domain\HumanResource\Student\Event\StudentWasAssignedToAnotherGroup::class,
        'StudentWasReaccepted' => \Domain\HumanResource\Student\Event\StudentWasReaccepted::class,
        'StudentNameWasChanged' => \Domain\HumanResource\Student\Event\StudentNameWasChanged::class,

    // Finance
        // students
        'StudentMadePayment' => \Domain\Finance\Student\Event\StudentMadePayment::class,
        'PaymentWasCancelled' => \Domain\Finance\Student\Event\PaymentWasCancelled::class,
        'StudentPaidForLesson' => \Domain\Finance\Student\Event\StudentPaidForLesson::class,
        'StudentGotDebtForLesson' => \Domain\Finance\Student\Event\StudentGotDebtForLesson::class,
        'StudentPaidOffDebt' => \Domain\Finance\Student\Event\StudentPaidOffDebt::class,
    ],
];
