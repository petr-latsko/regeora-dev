<?php

namespace App\Data;

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
