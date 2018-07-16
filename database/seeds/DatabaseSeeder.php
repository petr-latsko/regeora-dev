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
        $data->getSchedules()->each(function ($schedule) use ($inserts, $faker) {
            $schedule->getShifts()->each(function ($shift) use ($inserts, $faker) {
                $shift->getEvents()->each(function ($event) use ($inserts, $faker) {
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

        DB::table('stop_points')->insert($inserts->values()->toArray());
    }
}
