<?php

namespace FluxEco\PhpModelClassGenerator\Core\Ports;

use FluxEco\PhpModelClassGenerator\Core\Domain;

interface Outbounds
{
    public function getPhpClassFromSchemaFile($nameSpace, $schemaFilePath) : Domain\PhpClassAggregateRoot;
}