<?php

namespace FluxEco\PhpClassGenerator\Core\Domain\Models;

class Property
{

    private function __construct(
        public readonly string $key,
        public readonly string $type,
        public readonly null|string|int $default = null
    ) {

    }

    public static function new(
        string $key,
        string $type,
        null|string|int $default = null,
    ) {
        return new self(...get_defined_vars());
    }

    public function hasDefaultValue() : bool
    {
        return (!is_null($this->default));
    }
}