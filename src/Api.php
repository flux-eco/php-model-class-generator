<?php

namespace FluxEco\PhpModelClassGenerator;

class Api
{

    private Core\Ports\Service $service;

    private function __construct(Core\Ports\Service $service)
    {
        $this->service = $service;
    }

    public static function new(): self
    {
        $outbounds = Adapters\Outbounds::new();
        return new self(Core\Ports\Service::new($outbounds));
    }

    public function generateModelClass(string $schemaFilePath, string $nameSpace, string $targetDirectoryPath) : void
    {
        $this->service->generateModelClass($schemaFilePath, $nameSpace, $targetDirectoryPath);
    }
}