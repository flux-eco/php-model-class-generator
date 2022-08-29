<?php

namespace FluxEco\PhpClassGenerator\Core\Domain\Models;

class JsonSchema {

    private function __construct(
        public JsonSchemaType $type,
        private array $schema
    ) {

    }

    public static function new(
        JsonSchemaType $type,
        array $schema
    ) : self {
        return new self($type, $schema);
    }

}