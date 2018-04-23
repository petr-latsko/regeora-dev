<?php

namespace App\Services\Interfaces;

use SimpleXMLElement;

interface SourceParser
{
    /**
     * @return SourceParser
     */
    public function parse(): SourceParser;

    /**
     * @return SimpleXMLElement
     */
    public function get(): SimpleXMLElement;

    /**
     * @return array
     */
    public function toArray(): array;
}
