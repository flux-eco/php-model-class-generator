<?php

namespace FluxEco\PhpClassGenerator\Adapters\Models;

enum JsonSchemaType: string
{
    case OBJECT = 'object';
    case ARRAY = 'array';
    case INTEGER = 'integer';
    case STRING = 'string';

    public function toDomain(array $jsonProperty) : string
    {
        return match ($this) {
            self::INTEGER => 'int',
            self::OBJECT => $jsonProperty[JsonSchemaKeyword::title->name],
            default => $this->value
        };
    }

}
