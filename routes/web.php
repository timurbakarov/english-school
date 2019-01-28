<?php /** @var $router \Illuminate\Routing\Router */

use App\Http\Controllers;

$router->group(['middleware' => ['http-auth']], function(\Illuminate\Routing\Router $router) {
    $router->get('/', Controllers\Schedule\ScheduleCurrentController::class);
    $router->get('/journal', Controllers\Journal\JournalGroupsController::class);
    $router->get('/journal/{id}', Controllers\JournalController::class);
    $router->get('/journal/{year}/{month}', Controllers\JournalController::class);
    $router->get('/journal/{id}/{year}/{month}', Controllers\JournalController::class);

    $router->get('/students', Controllers\StudentsList::class);
    $router->get('/students/create', Controllers\Student\StudentsFormController::class);
    $router->get('/students/edit/{id}', Controllers\Student\StudentsFormController::class);
    $router->post('/students/accept', Controllers\Student\StudentAcceptController::class);
    $router->post('/students/update/{id}', Controllers\StudentsUpdateController::class);
    $router->get('/students/view/{id}', Controllers\StudentsViewController::class);
    $router->post('/students/move-to-group/{id}', Controllers\Student\StudentMoveToAnotherGroupController::class);
    $router->post('/students/dismiss/{id}', Controllers\Student\StudentsDismissController::class);
    $router->post('/students/reaccept/{id}', Controllers\Student\StudentsReacceptController::class);
    $router->post('/students/update/{field}/{id}', Controllers\Student\StudentUpdateProfileController::class);

    $router->get('/groups', Controllers\Group\GroupListController::class);
    $router->get('/groups/create', Controllers\GroupsForm::class);
    $router->get('/groups/edit/{id}', Controllers\GroupsForm::class);
    $router->post('/groups/store', Controllers\Group\CreateGroupController::class);
    $router->post('/groups/update/{id}', Controllers\Group\UpdateGroupController::class);

    $router->get('/schedule/general', Controllers\Schedule\ScheduleGeneralController::class);
    $router->get('/schedule/current', Controllers\Schedule\ScheduleCurrentController::class);

    $router->get('/payments', Controllers\PaymentsListController::class);
    $router->post('/payment/make/{id}', Controllers\Student\StudentMakePaymentController::class);
    $router->get('/payment/view/{id}', Controllers\PaymentViewController::class);
    $router->post('/payment/return/{id}', Controllers\PaymentCorrectionController::class . '@returnPayment');
    $router->post('/payment/cancel/{id}', Controllers\PaymentCorrectionController::class . '@cancelPayment');

    $router->get('/classes', Controllers\StudyClassesController::class);

    $router->post('/lesson/give', Controllers\Lesson\LessonGiveController::class);
    $router->post('/lesson/unmark-student/{studentId}/{lessonId}', Controllers\Lesson\UnmarkStudentController::class);

    $router->get('/stats', Controllers\StatsController::class);

    $router->group([], function(\Illuminate\Routing\Router $router) {
        $router->get('events/list', Controllers\Event\EventsListController::class);
        $router->post('events/delete/{id}', Controllers\Event\EventsDeleteController::class);
        $router->post('events/mass-delete', Controllers\Event\EventsDeleteController::class . '@massDelete');
    });
});
