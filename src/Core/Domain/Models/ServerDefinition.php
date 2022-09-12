<?php

namespace FluxEco\PhpClassGenerator\Core\Domain\Models;

interface ServerDefinition {
    public function getPath(): string;
    /** @return ServerRequestDefinition[] */
    public function getRequestDefinitions(): array;
}