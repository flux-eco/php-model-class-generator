<?php

namespace FluxEco\PhpModelClassGenerator\Core\Ports;

class Service
{
    private Outbounds $outbounds;

    private function __construct(Outbounds $outbounds)
    {
        $this->outbounds = $outbounds;
    }

    public static function new(Outbounds $outbounds)
    {
        return new self($outbounds);
    }

    public function generateModelClass(string $schemaFilePath, string $nameSpace, string $targetDirectoryPath): void
    {
        $phpClass = $this->outbounds->getPhpClassFromSchemaFile($nameSpace, $schemaFilePath);

        $classLines = $phpClass->getClassLines();
        file_put_contents($targetDirectoryPath . '/' . $phpClass->getName() . '.php', $classLines);
    }
}