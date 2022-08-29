<?php

namespace FluxEco\PhpClassGenerator\Core\Ports;

use FluxEco\PhpClassGenerator\Core\Domain;
use  FluxEco\PhpClassGenerator\Core\Application;

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

    public function createPhpClassCode(
        Commands\CreatePhpClassCode $command
    ): array {
        print_r($command);
        $aggregate = Domain\ClassDefinitionAggregate::create
        (
            Application\PhpCodeWriter::new(),
            $command->getClassName(),
            $command->getNamespace(),
            $command->getProperties(),
            $command->getNamespacesToImport(),
            $command->getConstances(),
            $command->getMethodsCode()
        );

        return $aggregate->writeCode();
    }

    public function createModelClassLines(
        string $className,
        string $namespace,
        array $schema,
        array $use = [],
        array $additionalLines = [],
        array $public_constants = []
    ) : array {

        $aggregate = Aggregate::new();
        return $aggregate->createModelClassLines(
            $className,
            $namespace,
            $schema,
            $use,
            $additionalLines,
            $public_constants
        );
    }

    public function createServiceClassLines(
        string $className,
        string $namespace,
        array $schema,
        array $use = [],
        array $additionalLines = [],
        array $public_constants = []
    ) : array {

        $aggregate = Aggregate::new();
        return $aggregate->createServiceClassLines(
            $className,
            $namespace,
            $schema,
            $use,
            $additionalLines,
            $public_constants
        );
    }

    public function storeClassFile(
        array $classLines,
        string $filePath,
    ) : void {
        $pathParts = explode("/", $filePath);

        $targetDirectoryPath = str_replace("/" . end($pathParts), "", $filePath);
        if (is_dir($targetDirectoryPath) === false) {
            mkdir($targetDirectoryPath);
        }

        file_put_contents($filePath, $classLines);
    }

}