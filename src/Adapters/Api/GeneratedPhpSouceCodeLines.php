<?php

namespace FluxEco\PhpClassGenerator\Adapters\Api;

class GeneratedPhpSouceCodeLines
{
    private function __construct(
        public string $targetFilePath,
        public string $sourceCodeLines
    ) {

    }

    public static function new(
        string $targetFilePath,
        string $sourceCodeLines
    ) : self {

        return new self(
            $targetFilePath,
            $sourceCodeLines
        );
    }
}