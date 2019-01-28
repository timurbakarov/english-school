<?php

namespace App\Console\Commands;

use Domain\Projectionist;
use Illuminate\Console\Command;

class ProjectionsReplay extends Command
{
    /**
     * @var string
     */
    protected $signature = 'projection:replay {projection?}';

    /**
     * @param Projectionist $projectionist
     * @throws \Domain\Exception\InvalidArgumentException
     */
    public function handle(Projectionist $projectionist)
    {
        $projection = $this->argument('projection');

        if($projection == 'all') {
            $projectionist->replayAll();
        } else if(!$projection) {
            foreach($projectionist->projections() as $projectionName => $projectionClass) {
                $this->info($projectionName);
            }
            $this->info("all");
        } else {
            $projectionist->replay($projection);

            $this->info("Done " . $projection);
        }
    }
}
