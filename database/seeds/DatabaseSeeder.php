<?php

use App\Data\EventEntity;
use App\Services\DataContractService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @param DataContractService $dataContractService
     * @return void
     */
    public function run(DataContractService $dataContractService)
    {
        $data = $dataContractService->get();
        $faker = app(Faker\Generator::class);

        $inserts = new Collection;
        $data->getGraphs()->each(function ($graph) use ($inserts, $faker) {
            $graph->getSmenas()->each(function ($smena) use ($inserts, $faker) {
                $smena->getEvents()->each(function ($event) use ($inserts, $faker) {
                    if ($event->getEvId() === EventEntity::INTERNAL_EV_ID) {
                        $event->getStops()->each(function ($stop) use ($inserts, $faker) {
                            if (! $inserts->has($stop->getStId())) {
                                $inserts->put($stop->getStId(), [
                                    'external_id' => $stop->getStId(),
                                    'name'        => $faker->name,
                                ]);
                            }
                        });
                    }
                });
            });
        });

        DB::table('StopPoints')->insert($inserts->values()->toArray());
    }
}
