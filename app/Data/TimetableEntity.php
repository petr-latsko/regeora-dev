<?php

namespace App\Data;

use Illuminate\Support\Collection;

class TimetableEntity extends AbstractEntity
{
    const CHILD_MAPPING = [
        'graph'  => 'ScheduleEntity',
    ];

    /**
     * @var ScheduleEntity[]|Collection
     */
    protected $schedules;

    /**
     * @var string
     */
    protected $snapTime;

    /**
     * @var int
     */
    protected $num;

    /**
     * @var string
     */
    protected $start;

    /**
     * @var string
     */
    protected $end;

    /**
     * @var int
     */
    protected $dow;

    /**
     * @var int
     */
    protected $mr_id;

    /**
     * @var string
     */
    protected $mr_num;

    /**
     * RaspvariantEntity constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        parent::__construct($attributes);

        $this->schedules = new Collection;
    }

    /**
     * @param \App\Data\AbstractEntity $childEntity
     */
    public function setChildEntity(AbstractEntity $childEntity): void
    {
        $this->setScheduleEntity($childEntity);
    }

    /**
     * @param ScheduleEntity $schedule
     */
    public function setScheduleEntity(ScheduleEntity $schedule): void
    {
        $num = $schedule->getNum();
        if (! $this->schedules->has($num)) {
            $this->schedules->put($num, $schedule);
        } else {
            $schedule->getShifts()->each(function (ShiftEntity $shift) use ($num) {
                $this->schedules->get($num)->setShiftEntity($shift);
            });
            $this->schedules->sortKeys();
        }
    }

    /**
     * @return ScheduleEntity[]|Collection
     */
    public function getSchedules(): Collection
    {
        return $this->schedules;
    }

    /**
     * @return string
     */
    public function getSnapTime(): string
    {
        return $this->snapTime;
    }

    /**
     * @return int
     */
    public function getNum(): int
    {
        return $this->num;
    }

    /**
     * @return string
     */
    public function getStart(): string
    {
        return $this->start;
    }

    /**
     * @return string
     */
    public function getEnd(): string
    {
        return $this->end;
    }

    /**
     * @return int
     */
    public function getDow(): int
    {
        return $this->dow;
    }

    /**
     * @return int
     */
    public function getMrId(): int
    {
        return $this->mr_id;
    }

    /**
     * @return string
     */
    public function getMrNum(): string
    {
        return $this->mr_num;
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
     * @return ScheduleEntity[]|Collection
     */
    public function getChildren(): Collection
    {
        return $this->getSchedules();
    }
}
