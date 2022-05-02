<?php

namespace FluxEco\PhpModelClassGenerator\Adapters;
use FluxEco\PhpModelClassGenerator\{Adapters, Core\Domain, Core\Ports};
use fluxJsonSchemaDocument;

class Outbounds implements Ports\Outbounds
{

    private function __construct()
    {

    }

    public static function new() : self
    {
        return new self();
    }


    public function getPhpClassFromSchemaFile($nameSpace, $schemaFilePath) : Domain\PhpClassAggregateRoot
    {
        $schemaDocument = fluxJsonSchemaDocument\getSchemaDocument($schemaFilePath);
        $classSchema = Domain\PhpClassAggregateRoot::new($nameSpace, $schemaDocument->getTitle());
        foreach ($schemaDocument->getProperties() as $property) {
            $classSchema->addProperty($property->getKey(), $property->getType());
        }
        return $classSchema;
    }
}