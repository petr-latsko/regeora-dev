<?php

namespace App\Data;

use App\Exceptions\EntityFactoryException;

class EntityFactory implements EntityFactoryInterface
{
    const ROOT_ENTITY_CLASS = 'TimetableEntity';

    public function build(string $entityClass, ...$args): AbstractEntity
    {
        $entityClass = __NAMESPACE__ . '\\' . $entityClass;

        if (! class_exists($entityClass)) {
            throw new EntityFactoryException('Entity class is not exists');
        }

        $entity = new $entityClass(...$args);

        return $entity;
    }
}
