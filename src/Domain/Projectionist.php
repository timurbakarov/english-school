<?php

namespace Domain;

use Infr\Event\EventMapper;
use Domain\Contract\EventStore;
use Domain\Projection\PaymentsProjection;
use Domain\Projection\StudentsProjection;
use Domain\Projection\StudyClassProjection;
use Domain\Projection\StatsByWeekProjection;
use Domain\Projection\StudentStatsProjection;
use Domain\Projection\StatsByMonthProjection;
use Domain\Projection\StudentClassProjection;
use Domain\Exception\InvalidArgumentException;
use Domain\Projection\StudentByGroupProjection;
use Domain\Education\StudentGroup\Projection\StudentsGroupProjection;
use Domain\Education\StudentGroup\Projection\StudentsGroupScheduleProjection;

class Projectionist
{
    /**
     * @var array
     */
    private $projections = [
        'students' => StudentsProjection::class,
        'groups' => StudentsGroupProjection::class,
        'schedule' => StudentsGroupScheduleProjection::class,
        'payments' => PaymentsProjection::class,
        'study_class' => StudyClassProjection::class,
        'student_class' => StudentClassProjection::class,

        'student_stat' => StudentStatsProjection::class,
        'stats_by_month' => StatsByMonthProjection::class,
        'stats_by_week' => StatsByWeekProjection::class,
        'students_by_group_and_date' => StudentByGroupProjection::class,
    ];
    /**
     * @var EventStore
     */
    private $eventStore;

    /**
     * @var EventMapper
     */
    private $eventMapper;

    /**
     * Projectionist constructor.
     * @param EventStore $eventStore
     * @param EventMapper $eventMapper
     */
    public function __construct(EventStore $eventStore, EventMapper $eventMapper)
    {
        $this->eventStore = $eventStore;
        $this->eventMapper = $eventMapper;
    }

    /**
     * @return array
     */
    public function projections()
    {
        return $this->projections;
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    final public function subscribe($events)
    {
        foreach($this->projections as $projection) {
            app($projection)->subscribe($events);
        }
    }

    public function replayAll()
    {
        foreach($this->projections as $projectionName => $projection) {
            $this->replay($projectionName);
        }
    }

    public function replay($projection)
    {
        if(!isset($this->projections[$projection])) {
            throw new InvalidArgumentException("Projection does not exist");
        }

        /** @var BaseProjection $projection */
        $projection = app($this->projections[$projection]);

        $readModel = $projection->readModel();
        if($readModel) {
            $readModel->truncate();
        }

        $events = $this->eventStore->byEvents($this->eventMapper->mapManyFromClassToName($projection->events()));

        foreach($events as $event) {
            $eventClass = $this->eventMapper->mapFromClassToName($event);

            $segments = explode('\\', $eventClass);
            $eventName = end($segments);

            $method = 'when' . $eventName;

            $projection->$method($event);
        }
    }
}
