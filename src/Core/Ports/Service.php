<?php

namespace FluxEco\PhpModelClassGenerator\Core\Ports;

class Service
{
    private Configs\Outbounds $outbounds;

    private function __construct(Configs\Outbounds $outbounds)
    {
        $this->outbounds = $outbounds;
    }

    public static function new(Configs\Outbounds $outbounds)
    {
        return new self($outbounds);
    }

    public function generateModelClass(string $schemaFilePath, string $nameSpace, string $targetDirectoryPath): void
    {
        $phpClass = $this->outbounds->getSchemaReader()->getPhpClassFromSchemaFile($nameSpace, $schemaFilePath);

        $classLines = $phpClass->getClassLines();
        file_put_contents($targetDirectoryPath . '/' . $phpClass->getName() . '.php', $classLines);
    }
}