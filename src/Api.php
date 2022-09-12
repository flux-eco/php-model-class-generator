<?php

namespace FluxEco\PhpClassGenerator;
use FluxEco\PhpClassGenerator\Adapters\Api\GenerateServerRequest;
use  FluxEco\PhpClassGenerator\Core\Domain;
use FluxEco\PhpClassGenerator\Adapters\Commands\CreatePhpClassCode;
use FluxEco\PhpClassGenerator\Adapters\Commands\CreatePhpServerCode;

class Api
{

    private Core\Ports\Service $service;

    private function __construct(Core\Ports\Service $service)
    {
        $this->service = $service;
    }

    public static function new() : self
    {
        $outbounds = Adapters\Outbounds::new();
        return new self(Core\Ports\Service::new($outbounds));
    }

    public function generatePhpClass(Adapters\Api\GeneratePhpClassRequest $generatePhpClassRequest): array {
        print_r($generatePhpClassRequest);
        return $this->service->createPhpClassCode(
            CreatePhpClassCode::fromRequest($generatePhpClassRequest)
        );
    }

    public function generateServer(string $serverId, string $serverUrl, array $operationBindings): array {
        return $this->service->createPhpServerCode(
            GenerateServerRequest::fromHttpOperationBinding($serverId, $serverUrl, $operationBindings)->toCommand();
        )
    }

    public function generateServiceClassLines(
        string $className,
        string $namespace,
        string $filePath,
        array $schema,
        array $use = [],
        array $additionalLines = [],
        array $public_constants = []
    ) : void {
        $classLines = $this->service->createServiceClassLines($className, $namespace, $schema, $use, $additionalLines,
            $public_constants);
        $this->service->storeClassFile($classLines, $filePath);
    }

    public function generateModelClassLines(
        string $className,
        string $namespace,
        string $filePath,
        array $schema,
        array $use = [],
        array $additionalLines = [],
        array $public_constants = []
    ) : void {
        $classLines = $this->service->createModelClassLines($className, $namespace, $schema, $use, $additionalLines, $public_constants);
        $this->service->storeClassFile($classLines, $filePath);
    }
}