<?php

namespace FluxEco\PhpClassGenerator\Core\Domain\Models;

class ParameterDefinition
{

    private function __construct(
        public readonly string $parameterId,
        public readonly JsonSchema $schema,
    ) {

    }

    public static function new(
        string $parameterId,
        array $schema
    ): self {
        return new self($parameterId,  JsonSchema::new(JsonSchemaType::from($schema[JsonSchemaKeyword::type->name]), $schema));
    }
}