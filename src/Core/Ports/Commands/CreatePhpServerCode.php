<?php

namespace FluxEco\PhpClassGenerator\Core\Ports\Commands;
use FluxEco\PhpClassGenerator\Core\Domain\Models;

interface CreatePhpServerCode {
    public function getServerId(): string;
    public function getServerUrl(): string;
    public function getServerType(): Models\ServerType;
    /** @return Models\ServerDefinition[] */
    public function getServerRequestDefinitions(): array;
}