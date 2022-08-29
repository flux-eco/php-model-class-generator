<?php

namespace FluxEco\PhpClassGenerator\Core\Domain\Models;

use function React\Promise\race;

enum JsonSchemaType: string
{
    case OBJECT = 'object';
    case ARRAY = 'array';
    case INTEGER = 'integer';
    case STRING = 'string';

    public static function fromJsonSchema(string $jsonSchema) : JsonSchema
    {
        $schema = json_decode($jsonSchema, true);
        $typeValue = $schema[JsonSchemaKeyword::type->name];
        return JsonSchema::new(JsonSchemaType::from($typeValue), $schema);
    }

}