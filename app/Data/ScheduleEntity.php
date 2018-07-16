<?php

namespace App\Data;

use Illuminate\Support\Collection;

class ScheduleEntity extends AbstractEntity
{
    const CHILD_MAPPING = [
        'event' => 'EventEntity',
    ];

    /**
     * @var int
     */
    protected $num;

    /**
     * @var ShiftEntity[]|Collection
     */
    protected $shifts;

    /**
     * GraphEntity constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        parent::__construct($attributes);

        $this->shifts = new Collection;

        $this->setShiftEntity(new ShiftEntity($attributes));
    }

    /**
     * @return array
     */
    public function getStatisticEvents(): array
    {
        $stat = (object)[
            'countEvents'    => 0,
            'durationEvents' => 0,
        ];

        $this->getShifts()->each(function ($shift) use ($stat) {
            $shift->getEvents()->each(function ($event) use ($stat) {
                if ($event->getEvId() === EventEntity::INTERNAL_EV_ID) {
                    $stat->countEvents++;
                    $stat->durationEvents += $event->getDuration();
                }
            });
        });

        return (array)$stat;
    }

    /**
     * @param array $times as format ['from' => 'H:i', 'till' => 'H:i']
     * @return StopEntity[]|Collection
     */
    public function getStopsList(array $times = ['from' => '', 'till' => '']): Collection
    {
        $stops = new Collection;

        $this->getShifts()->each(function ($shift) use ($stops, $times) {

            return $shift->getEvents()->each(function ($event, $idxEvent) use ($shift, $stops, $times) {

                if ($event->getEvId() === EventEntity::INTERNAL_EV_ID) {

                    return $event->getStops()->each(function ($stop) use ($shift, $idxEvent, $stops, $times) {

                        $condition = true;

                        if (!empty($times['from']) && !empty($times['till'])) {
                            $condition = $stop->getTime() >= $times['from'] && $stop->getTime() <= $times['till'];
                        } elseif (!empty($times['from'])) {
                            $condition = $stop->getTime() >= $times['from'];
                        } elseif (!empty($times['till'])) {
                            $condition = $stop->getTime() <= $times['till'];
                        }

                        if ($condition) {
                            $stop->setMetaCollection(
                                new MetaCollection(
                                    [
                                        'smena_num' => $shift->getNum(),
                                        'event_num' => $idxEvent + 1,
                                        'stop_name' => $stop->findName(),
                                    ]
                                )
                            );
                            $stops->push($stop);
                        }
                    });
                }
            });
        });

        return $stops;
    }

    /**
     * @param \App\Data\AbstractEntity $childEntity
     */
    public function setChildEntity(AbstractEntity $childEntity): void
    {
        $this->setEventEntity($childEntity);
    }

    /**
     * @param ShiftEntity $shift
     */
    public function setShiftEntity(ShiftEntity $shift): void
    {
        $this->shifts->put($shift->getNum(), $shift);
        $this->shifts->sortKeys();
    }

    /**
     * @return ShiftEntity[]|Collection
     */
    public function getShifts(): Collection
    {
        return $this->shifts;
    }

    /**
     * @param EventEntity $event
     */
    public function setEventEntity(EventEntity $event): void
    {
        $this->shifts->last()->setEventEntity($event);
    }

    /**
     * @return int
     */
    public function getNum(): int
    {
        return $this->num;
    }

    /**
     * Get mapping for children entities
     */
    public function getMapping(): array
    {
        return self::CHILD_MAPPING;
    }

    /**
     * Get children entities
     * @return ShiftEntity[]|Collection
     */
    public function getChildren(): Collection
    {
        return $this->getShifts();
    }
}
