<?php

namespace FluxEco\PhpModelClassGenerator\Adapters\Configs;
use FluxEco\PhpModelClassGenerator\{Adapters, Core\Ports};

class Outbounds implements Ports\Configs\Outbounds
{

    private function __construct()
    {

    }

    public static function new() : self
    {
        return new self();
    }

    public function getSchemaReader() : Ports\SchemaReader\SchemaReaderClient
    {
        return Adapters\SchemaReader\SchemaReaderClient::new();
    }
}