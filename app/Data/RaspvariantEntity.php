<?php

namespace App\Data;

use Illuminate\Support\Collection;

class RaspvariantEntity extends AbstractEntity
{
    /**
     * @var GraphEntity[]|Collection
     */
    protected $graphs;

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

        $this->graphs = new Collection;
    }

    /**
     * @param GraphEntity $graph
     */
    public function setGraph(GraphEntity $graph): void
    {
        $num = $graph->getNum();
        if (! $this->graphs->has($num)) {
            $this->graphs->put($num, $graph);
        } else {
            $this->graphs->get($num)->setSmena($graph->getSmenas()->first());
            $this->graphs->sortKeys();
        }
    }

    /**
     * @return GraphEntity[]|Collection
     */
    public function getGraphs(): Collection
    {
        return $this->graphs;
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
}
