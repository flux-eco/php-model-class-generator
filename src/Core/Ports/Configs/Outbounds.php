<?php

namespace FluxEco\PhpModelClassGenerator\Core\Ports\Configs;
use FluxEco\PhpModelClassGenerator\Core\Ports;

interface Outbounds {
    public function getSchemaReader(): Ports\SchemaReader\SchemaReaderClient;
}