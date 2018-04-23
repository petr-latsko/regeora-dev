<?php

namespace App\Data;

use Illuminate\Support\Collection;

class SmenaEntity extends AbstractEntity
{
    /**
     * @var EventEntity[]|Collection
     */
    protected $events;

    /**
     * @var int
     */
    protected $num;

    /**
     * @var int
     */
    protected $parent_num;

    /**
     * @var float
     */
    protected $nullRun;

    /**
     * @var float
     */
    protected $lineRun;

    /**
     * @var float
     */
    protected $totalRun;

    /**
     * @var int
     */
    protected $nullTime;

    /**
     * @var int
     */
    protected $lineTime;

    /**
     * @var int
     */
    protected $otsTime;

    /**
     * @var int
     */
    protected $totalTime;

    /**
     * @var int
     */
    protected $garageOut;

    /**
     * @var int
     */
    protected $garageIn;

    /**
     * @var string
     */
    protected $lineBegin;

    /**
     * @var string
     */
    protected $lineEnd;

    /**
     * SmenaEntity constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        [$attributes['num'], $attributes['parent_num']] = [$attributes['smena'], $attributes['num']];

        parent::__construct($attributes);

        $this->events = new Collection;
    }

    /**
     * @param EventEntity $event
     */
    public function setEvent(EventEntity $event): void
    {
        $this->events->push($event);
    }

    /**
     * @return EventEntity[]|Collection
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    /**
     * @return int
     */
    public function getNum(): int
    {
        return $this->num;
    }

    /**
     * @return int
     */
    public function getParentNum(): int
    {
        return $this->parent_num;
    }

    /**
     * @return float
     */
    public function getNullRun(): float
    {
        return $this->nullRun;
    }

    /**
     * @return float
     */
    public function getLineRun(): float
    {
        return $this->lineRun;
    }

    /**
     * @return float
     */
    public function getTotalRun(): float
    {
        return $this->totalRun;
    }

    /**
     * @return int
     */
    public function getNullTime(): int
    {
        return $this->nullTime;
    }

    /**
     * @return int
     */
    public function getLineTime(): int
    {
        return $this->lineTime;
    }

    /**
     * @return int
     */
    public function getOtsTime(): int
    {
        return $this->otsTime;
    }

    /**
     * @return int
     */
    public function getTotalTime(): int
    {
        return $this->totalTime;
    }

    /**
     * @return int
     */
    public function getGarageOut(): int
    {
        return $this->garageOut;
    }

    /**
     * @return int
     */
    public function getGarageIn(): int
    {
        return $this->garageIn;
    }

    /**
     * @return string
     */
    public function getLineBegin(): string
    {
        return $this->lineBegin;
    }

    /**
     * @return string
     */
    public function getLineEnd(): string
    {
        return $this->lineEnd;
    }
}
