<?php

namespace App\Http\Controllers;

use App\Data\ScheduleEntity;
use App\Services\DataContractService;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * Application Index page.
     * @param \Illuminate\Http\Request $request
     * @param DataContractService      $dataContractService
     * @throws \App\Exceptions\EntityFactoryException
     */
    public function index(Request $request, DataContractService $dataContractService)
    {
        $dbDebug = collect();

        \Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) use ($dbDebug) {
            $dbDebug->push(
                [
                    'sql'      => $query->sql,
                    'bindings' => $query->bindings,
                    'time'     => $query->time,
                ]
            );
        });

        $data = $dataContractService->get();
        $data->dump();

        /** @var ScheduleEntity $schedule */
        $schedule = $data->getChildren()->first();

        $eventsStat = $schedule->getStatisticEvents();
        dump($eventsStat);

        $params = [
            'from' => $request->input('from', '12:00'),
            'till' => $request->input('till', '13:00'),
        ];
        $eventsStops = $schedule->getStopsList($params);
        dump($eventsStops);

        dump(
            [
                'Total queries count' => $dbDebug->count(),
                'Total queries time'  => $dbDebug->sum('time'),
                'Queries list'        => $dbDebug->toArray(),
            ]
        );
    }
}
