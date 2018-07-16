<?php

namespace App\Data;

use Illuminate\Support\Collection;

abstract class AbstractEntity
{
    /**
     * AbstractEntity constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        foreach ($attributes as $property => $value) {
            if (property_exists(static::class, $property)) {
                $this->$property = $value;
            }
        }
    }

    /**
     * Get mapping for children entities
     * @return array
     */
    abstract public function getMapping(): array;

    /**
     * Get children entities
     * @return Collection
     */
    abstract public function getChildren(): Collection;

    /**
     * Set child entity
     * @param AbstractEntity $childEntity
     */
    abstract public function setChildEntity(AbstractEntity $childEntity): void;

    /**
     * For test & debug
     */
    public function dump(): void
    {
        if (function_exists('dump')) {
            dump($this);
        } else {
            var_dump($this);
        }
    }
}
