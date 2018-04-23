<?php

namespace App\Data;

use Illuminate\Support\Collection;

class EventEntity extends AbstractEntity
{
    /**
     * Internal events id
     */
    const INTERNAL_EV_ID = 4;

    /**
     * @var StopEntity[]|Collection
     */
    protected $stops;

    /**
     * @var int
     */
    protected $ev_id;

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
    protected $departureID;

    /**
     * @var int
     */
    protected $arrivalID;

    /**
     * @var float
     */
    protected $distance;

    /**
     * @var int
     */
    protected $duration;

    /**
     * EventEntity constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        parent::__construct($attributes);

        $this->stops = new Collection;
    }

    /**
     * @param StopEntity $stop
     */
    public function setStop(StopEntity $stop)
    {
        $this->stops->push($stop);
    }

    /**
     * @return StopEntity[]|Collection
     */
    public function getStops()
    {
        return $this->stops;
    }

    /**
     * @return int
     */
    public function getEvId(): int
    {
        return $this->ev_id;
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
    public function getDepartureID(): int
    {
        return $this->departureID;
    }

    /**
     * @return int
     */
    public function getArrivalID(): int
    {
        return $this->arrivalID;
    }

    /**
     * @return float
     */
    public function getDistance(): float
    {
        return $this->distance;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }
}
