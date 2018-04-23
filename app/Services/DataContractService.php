<?php

namespace App\Services;

use App\Data\AbstractEntity;
use App\Data\RaspvariantEntity;
use App\Services\Interfaces\SourceParser;
use SimpleXMLElement;

class DataContractService
{
    /**
     * @var SourceParser
     */
    private $parser;

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
     * @param SourceParser $parser
     */
    public function __construct(SourceParser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @return AbstractEntity
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
     */
    protected function prepare(): void
    {
        $this->data = $this->data
            ?? $this->iterate(
                $this->xml->children(),
                new RaspvariantEntity($this->attributesToArray($this->xml))
            );
    }

    /**
     * @param SimpleXMLElement $element
     * @param AbstractEntity   $node
     * @return AbstractEntity
     */
    protected function iterate(SimpleXMLElement $element, AbstractEntity $node): AbstractEntity
    {
        foreach ($element as $name => $xml) {
            $childEntityClass = 'App\\Data\\' . ucfirst($name) . 'Entity';
            $method = 'set' . ucfirst($name);
            $node->$method(
                $this->iterate(
                    $xml->children(),
                    new $childEntityClass($this->attributesToArray($xml))
                )
            );
        }
        return $node;
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
