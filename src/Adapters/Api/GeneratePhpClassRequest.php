<?php

namespace FluxEco\PhpClassGenerator\Adapters\Api;

class GeneratePhpClassRequest
{
    private function __construct(
        public string $applicationNamespace,
        public string $className,
        public ?string $subNamespace = null,
        public array $jsonOjectSchema = [],
        public array $namespacesToImports = [],
        public array $methodSourceCodeLines = []
    ) {

    }

    public static function new(
        string $applicationNamespace,
        string $className,
        ?string $subNamespace = null,
        array $jsonOjectSchema = [],
        array $namespacesToImports = [],
        array $methodSourceCodeLines = []
    ) : self {
        //todo validate with schema
        return new self(
            ...get_defined_vars()
        );
    }
}