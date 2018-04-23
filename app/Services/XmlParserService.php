<?php

namespace App\Services;

use App\Services\Interfaces\SourceParser;
use ReflectionMethod;
use SimpleXMLElement;

class XmlParserService implements SourceParser
{
    /**
     * @var SimpleXMLElement
     */
    protected $xml;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $source;

    /**
     * XmlServiceParser constructor.
     * @param string $source path to file contents XML-data|legal XML string
     */
    public function __construct(string $source = '')
    {
        $this->source = $source;
        $this->method = starts_with($source, '<?xml') ? 'parseString' : 'parseFile';
    }

    /**
     * @return SourceParser
     * @throws \ReflectionException
     */
    public function parse(): SourceParser
    {
        $reflectionMethod = new ReflectionMethod(__CLASS__, $this->method);
        $reflectionMethod->invokeArgs($this, [$this->source]);
        return $this;
    }

    /**
     * @return SimpleXMLElement
     */
    public function get(): SimpleXMLElement
    {
        return $this->xml;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = [];
        if ($this->xml instanceof SimpleXMLElement) {
            $data = json_decode(
                json_encode((array)$this->xml),
                true
            );
        }
        return $data;
    }

    /**
     * @param string $filename
     * @param int    $options
     * @return SimpleXMLElement
     */
    public function parseFile(string $filename, $options = LIBXML_NOCDATA): SimpleXMLElement
    {
        return $this->xml = simplexml_load_file($filename, 'SimpleXMLElement', $options);
    }

    /**
     * @param string $string
     * @param int    $options
     * @return SimpleXMLElement
     */
    public function parseString(string $string, $options = LIBXML_NOCDATA): SimpleXMLElement
    {
        return $this->xml = simplexml_load_string($string, 'SimpleXMLElement', $options);
    }
}
