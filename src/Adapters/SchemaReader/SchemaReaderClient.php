<?php

namespace FluxEco\PhpModelClassGenerator\Adapters\SchemaReader;

use FluxEco\PhpModelClassGenerator\Core\Ports;
use FluxEco\PhpModelClassGenerator\Core\Domain;
use FluxEco\JsonSchemaDocument\Adapters\Api\JsonSchemaDocumentApi;

class SchemaReaderClient implements Ports\SchemaReader\SchemaReaderClient
{

    private function __construct()
    {

    }

    public static function new() : self
    {
        return new self();
    }

    public function getPhpClassFromSchemaFile( string $nameSpace, string $schemaFilePath) : Domain\PhpClassAggregateRoot
    {
        $schemaFileReader = JsonSchemaDocumentApi::new();
        $schemaDocument = $schemaFileReader->getSchemaDocument($schemaFilePath);

        $classSchema = Domain\PhpClassAggregateRoot::new($nameSpace, $schemaDocument->getName());
        foreach ($schemaDocument->getProperties() as $property) {
            $classSchema->addProperty($property->getKey(), $property->getType());
        }

        return $classSchema;
    }
}