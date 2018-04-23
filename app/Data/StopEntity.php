<?php

namespace App\Data;

use Illuminate\Support\Facades\DB;

class StopEntity extends AbstractEntity
{
    /**
     * @var array
     */
    protected $meta;

    /**
     * @var int
     */
    protected $st_id;

    /**
     * @var string
     */
    protected $time;

    /**
     * @var float
     */
    protected $distanceToNext;

    /**
     * @var bool
     */
    protected $kp;

    /*
     * Find the stop name in DB
     */
    public function findName(): ?string
    {
        $row = DB::table('StopPoints')->where('external_id', $this->getStId())->first();

        return ! $row ? null : $row->name;
    }

    /**
     * @param array $meta
     */
    public function setMeta(array $meta)
    {
        $this->meta = $meta;
    }

    /**
     * @return array|$meta[]
     */
    public function getMeta(): array
    {
        return $this->meta;
    }

    /**
     * @return int
     */
    public function getStId(): int
    {
        return $this->st_id;
    }

    /**
     * @return string
     */
    public function getTime(): string
    {
        return $this->time;
    }

    /**
     * @return float
     */
    public function getDistanceToNext(): float
    {
        return $this->distanceToNext;
    }

    /**
     * @return bool
     */
    public function isKp(): bool
    {
        return $this->kp;
    }
}
