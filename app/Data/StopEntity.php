<?php

namespace App\Data;

use App\Models\StopPoints;
use Illuminate\Support\Collection;

class StopEntity extends AbstractEntity
{
    const CHILD_MAPPING = [
        'meta' => 'MetaCollection',
    ];

    /**
     * @var \App\Data\MetaCollection
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

    /**
     * @var StopPoints[]|Collection
     */
    protected static $repository;

    /**
     * StopEntity constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        parent::__construct($attributes);

        self::$repository = self::$repository ?? StopPoints::all()->keyBy('external_id');
    }

    /*
     * Find the stop name
     */
    public function findName(): ?string
    {
        $row = self::$repository->get($this->getStId());

        return $row->name ?? null;
    }

    /**
     * @param \App\Data\MetaCollection $meta
     */
    public function setMetaCollection(MetaCollection $meta): void
    {
        $this->meta = $meta;
    }

    /**
     * @return \App\Data\MetaCollection
     */
    public function getMeta(): MetaCollection
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

    /**
     * Get mapping for children entities
     */
    public function getMapping(): array
    {
        return self::CHILD_MAPPING;
    }

    /**
     * Get children entities
     * @return Collection
     */
    public function getChildren(): Collection
    {
        return $this->getMeta();
    }

    /**
     * Set children entities
     * @param AbstractEntity $childEntity
     */
    public function setChildEntity(AbstractEntity $childEntity): void
    {
        // Have no children
    }
}
