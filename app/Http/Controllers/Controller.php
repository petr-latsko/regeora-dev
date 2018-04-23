<?php

namespace App\Http\Controllers;

use App\Services\DataContractService;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * Application Index page.
     * @param DataContractService $dataContractService
     */
    public function index(DataContractService $dataContractService)
    {
        $data = $dataContractService->get();
        $data->dump();

        $eventsStat = $data->getGraphs()->first()->getEventStat();
        dump($eventsStat);

        $eventsStops = $data->getGraphs()->first()->getEventStops(['from' => '12:00', 'till' => '13:00']);
        dump($eventsStops);
    }
}
