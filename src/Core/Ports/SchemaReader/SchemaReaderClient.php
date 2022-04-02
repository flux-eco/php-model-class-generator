<?php

namespace FluxEco\PhpModelClassGenerator\Core\Ports\SchemaReader;

use FluxEco\PhpModelClassGenerator\Core\Domain;

interface SchemaReaderClient
{
    public function getPhpClassFromSchemaFile(string $nameSpace, string $schemaFilePath): Domain\PhpClassAggregateRoot;
}