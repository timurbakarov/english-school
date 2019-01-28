<?php

return [
    'map' => [
        \Domain\StudentId::class => [
            'human_resource' => \Domain\HumanResource\Student::class,
            'finance' => \Domain\Finance\Student::class,
        ],
        \Domain\Education\StudentGroup\StudentGroupId::class => \Domain\Education\StudentGroup::class,
        \Domain\LessonId::class => \Domain\Education\Lesson::class,
    ],
];
