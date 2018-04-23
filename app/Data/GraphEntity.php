<?php

namespace App\Data;

use Illuminate\Support\Collection;

class GraphEntity extends AbstractEntity
{
    /**
     * @var int
     */
    protected $num;

    /**
     * @var SmenaEntity[]|Collection
     */
    protected $smenas;

    /**
     * GraphEntity constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        parent::__construct($attributes);

        $this->smenas = new Collection;

        $this->setSmena(new SmenaEntity($attributes));
    }

    /**
     * @return array
     */
    public function getEventStat()
    {
        $stat = [
            'countEvents' => 0,
            'durationEvents' => 0,
        ];

        $this->getSmenas()->each(function ($smena) use (&$stat) {
            $smena->getEvents()->each(function ($event) use (&$stat) {
                if ($event->getEvId() === EventEntity::INTERNAL_EV_ID) {
                    $stat['countEvents']++;
                    $stat['durationEvents'] += $event->getDuration();
                }
            });
        });

        return $stat;
    }

    /**
     * @param array $times as format ['from' => 'H:i', 'till' => 'H:i']
     * @param bool  $withNames
     * @return Collection
     */
    public function getEventStops(array $times = ['from' => '', 'till' => ''], bool $withNames = true)
    {
        $stops = new Collection;

        $this->getSmenas()->each(function ($smena) use ($stops, $times, $withNames) {
            return $smena->getEvents()->each(function ($event, $idxEvent) use ($smena, $stops, $times, $withNames) {
                if ($event->getEvId() === EventEntity::INTERNAL_EV_ID) {
                    return $event->getStops()->each(function ($stop) use ($smena, $idxEvent, $stops, $times, $withNames) {

                        $condition = true;
                        if (! empty($times['from']) && ! empty($times['till'])) {
                            $condition = $stop->getTime() >= $times['from'] && $stop->getTime() <= $times['till'];
                        } else if (! empty($times['from'])) {
                            $condition = $stop->getTime() >= $times['from'];
                        } else if (! empty($times['till'])) {
                            $condition = $stop->getTime() <= $times['till'];
                        }

                        if ($condition) {
                            $meta = [
                                'smena_num' => $smena->getNum(),
                                'event_num' => $idxEvent + 1,
                                'stop_name' => $stop->findName(),
                            ];
                            $stop->setMeta($meta);
                            $stops->push($stop);
                        }
                    });
                }
            });
        });

        return $stops;
    }

    /**
     * @param SmenaEntity $smena
     */
    public function setSmena(SmenaEntity $smena)
    {
        $this->smenas->put($smena->getNum(), $smena);
        $this->smenas->sortKeys();
    }

    /**
     * @return SmenaEntity[]|Collection
     */
    public function getSmenas(): Collection
    {
        return $this->smenas;
    }

    /**
     * @param EventEntity $event
     */
    public function setEvent(EventEntity $event)
    {
        $this->smenas->last()->setEvent($event);
    }

    /**
     * @return int
     */
    public function getNum(): int
    {
        return $this->num;
    }
}
