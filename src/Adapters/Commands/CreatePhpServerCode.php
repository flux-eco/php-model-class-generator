<?php

namespace FluxEco\PhpClassGenerator\Adapters\Commands;

use FluxEco\PhpClassGenerator\Adapters;
use FluxEco\PhpClassGenerator\Core\Domain\Models;
use FluxEco\PhpClassGenerator\Core\Ports;
use FluxEco\PhpClassGenerator\Core\Domain;

class CreatePhpServerCode implements Ports\Commands\CreatePhpServerCode
{
    private function __construct(
        private string                   $serverId,
        private string                   $serverUrl,
        private Domain\Models\ServerType $serverType,
        private array                    $serverRequestDefinitions,
    ) {

    }

    public static function fromRequest(
        Adapters\Api\GenerateServerRequest $generateServerRequest
    )
    {
        return new self(
            $generateServerRequest->serverId,
            $generateServerRequest->serverUrl,
            $generateServerRequest->serverType,
            $generateServerRequest->getRequestDefinitions(),
        );
    }

    public function getServerId(): string
    {
        return $this->serverId;
    }

    public function getServerUrl(): string
    {
        return $this->serverUrl;
    }

    public function getServerType(): Models\ServerType
    {
        return $this->serverType;
    }

    public function getServerRequestDefinitions(): array
    {
        return $this->serverRequestDefinitions;
    }
}
