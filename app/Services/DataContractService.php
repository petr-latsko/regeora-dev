<?php

namespace App\Services;

use App\Data\AbstractEntity;
use App\Data\EntityFactory;
use App\Services\Interfaces\SourceParser;
use SimpleXMLElement;

class DataContractService
{
    /**
     * @var \App\Services\Interfaces\SourceParser
     */
    private $parser;

    /**
     * @var \App\Data\EntityFactory
     */
    private $factory;

    /**
     * @var SimpleXMLElement
     */
    private $xml;

    /**
     * @var AbstractEntity
     */
    private $data;

    /**
     * DataTransferService constructor.
     * @param \App\Services\Interfaces\SourceParser $parser
     * @param \App\Data\EntityFactory               $factory
     */
    public function __construct(SourceParser $parser, EntityFactory $factory)
    {
        $this->parser = $parser;
        $this->factory = $factory;
    }

    /**
     * @return AbstractEntity
     * @throws \App\Exceptions\EntityFactoryException
     */
    public function get(): AbstractEntity
    {
        $this->load()->prepare();

        return $this->data;
    }

    /**
     * @return DataContractService
     */
    protected function load(): self
    {
        $this->xml = $this->xml ?? $this->parser->parse()->get();

        return $this;
    }

    /**
     * Preparing and create objects by contract with entities
     * @throws \App\Exceptions\EntityFactoryException
     */
    protected function prepare(): void
    {
        $rootEntity = $this->factory->build(
            EntityFactory::ROOT_ENTITY_CLASS,
            $this->attributesToArray($this->xml)
        );

        $this->data = $this->data ?? $this->iterate($rootEntity, $this->xml->children());
    }

    /**
     * @param AbstractEntity   $entity
     * @param SimpleXMLElement $xmlChildren
     * @return AbstractEntity
     * @throws \App\Exceptions\EntityFactoryException
     */
    protected function iterate(AbstractEntity $entity, SimpleXMLElement $xmlChildren): AbstractEntity
    {
        $mapping = $entity->getMapping();

        foreach ($xmlChildren as $name => $xmlElement) {

            $childEntity = $this->factory->build(
                $mapping[$name],
                $this->attributesToArray($xmlElement)
            );

            $entity->setChildEntity(
                $this->iterate($childEntity, $xmlElement->children())
            );
        }

        return $entity;
    }

    /**
     * @param SimpleXMLElement $xml
     * @return array
     */
    protected function attributesToArray(SimpleXMLElement $xml): array
    {
        $attributes = (array)((array)$xml->attributes())['@attributes'];
        return $attributes;
    }
}
