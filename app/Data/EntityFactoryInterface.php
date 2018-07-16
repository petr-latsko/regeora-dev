<?php

namespace App\Data;

interface EntityFactoryInterface
{
    public function build(string $entityClass, ...$args): AbstractEntity;
}
