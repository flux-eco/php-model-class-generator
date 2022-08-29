<?php

namespace FluxEco\PhpClassGenerator\Core\Domain\Models;

class NamespaceDefinition
{

    private function __construct(
        public string $namespace,
        public string $directoryPath
    ) {

    }

    public static function new(
        string $applicationNameSpace,
        string $applicationDirectoryPath,
        string $classSubNamespace = null,
        string $classSubDirectoryPath = null
    ) : self {
        if (!is_null($classSubNamespace)) {
            return new self(
                $applicationNameSpace . "\\" . $classSubNamespace,
                $applicationDirectoryPath . "//" . $classSubDirectoryPath
            );
        }
        return new self($applicationNameSpace, $applicationDirectoryPath);
    }
}