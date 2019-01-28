<?php

namespace App\Http\Controllers;

use App\Repository\StatsByMonthReadModel;
use App\Repository\StatsByWeekReadModel;

class StatsController
{
    public function __invoke(StatsByMonthReadModel $statsByMonthReadModel, StatsByWeekReadModel $statsByWeekReadModel)
    {
        $year = date('Y');

        $statsByMonth = $statsByMonthReadModel
            ->where('year', $year)
            ->orderBy('month', 'DESC')
            ->get();

        $statsByWeek = $statsByWeekReadModel
            ->where('year', $year)
            ->orderBy('week', 'DESC')
            ->get()->groupBy('month')->toArray();

        return view('stats', compact('statsByMonth', 'statsByWeek'));
    }
}
