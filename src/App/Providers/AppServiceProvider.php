<?php

namespace App\Providers;

use Illuminate\Log\Logger;
use Infr\Event\EventMapper;
use Domain\Contract\EventStore;
use Domain\Contract\CommandBus;
use Infr\Repository\RepositoryMapper;
use Infr\CommandBus\SameFolderLocator;
use Illuminate\Support\ServiceProvider;
use Infr\EventStore\EloquentEventStore;
use Infr\Repository\IdTypeToAggregateMapper;
use Infr\CommandBus\DbTransactionMiddleware;
use League\Tactician\Logger\LoggerMiddleware;
use Infr\CommandBus\TacticianCommandBusAdapter;
use League\Tactician\Handler\CommandHandlerMiddleware;
use Domain\Education\StudentGroup\StudentGroupSearcher;
use League\Tactician\Logger\Formatter\ClassPropertiesFormatter;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;

function group_schedules_compact(\Presentation\ScheduleCompact $scheduleCompact) {
    return view('partials.schedules_compact', ['schedules' => $scheduleCompact->schedule()]);
}

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CommandBus::class, $this->buildCommandBus());

        $this->app->singleton(EventStore::class, EloquentEventStore::class);

        $this->app->singleton(RepositoryMapper::class, function() {
            return new IdTypeToAggregateMapper(config('repository.map'));
        });

        $this->app->singleton(EventMapper::class, function() {
            return new EventMapper(config('events.map'));
        });

        $this->app->singleton(StudentGroupSearcher::class, \Infr\StudentGroup\StudentGroupSearcher::class);

        if($this->app->isLocal()) {
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * @return \Closure
     */
    private function buildCommandBus()
    {
        return function () {
            $inflector = new HandleInflector();

            $locator = new SameFolderLocator();

            $nameExtractor = new ClassNameExtractor();

            $commandHandlerMiddleware = new CommandHandlerMiddleware(
                $nameExtractor,
                $locator,
                $inflector
            );

            $commandBus = new TacticianCommandBusAdapter([
                $this->loggerMiddleware(),
                $this->dbTransactionMiddleware(),
                $commandHandlerMiddleware,
            ]);

            return $commandBus;
        };
    }

    /**
     * @return LoggerMiddleware
     */
    private function loggerMiddleware()
    {
        $formatter = new ClassPropertiesFormatter();

        return new LoggerMiddleware($formatter, $this->app->make(Logger::class)->driver('commands'));
    }

    /**
     * @return mixed
     */
    private function dbTransactionMiddleware()
    {
        return $this->app->make(DbTransactionMiddleware::class);
    }
}
