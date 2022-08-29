<?php

namespace FluxEco\PhpClassGenerator\Core\Domain\Models;

class Constance {

    private function __construct(
        public string $name,
        public mixed $value
    ) {

    }

    public static function new(
        string $name,
        mixed $value
    ): self {
        return new self(...get_defined_vars());
    }

}
