<?php

namespace FluxEco\PhpClassGenerator\Adapters\Commands;

use FluxEco\PhpClassGenerator\Adapters;
use FluxEco\PhpClassGenerator\Core\Ports;
use FluxEco\PhpClassGenerator\Core\Domain;

class CreatePhpClassCode implements Ports\Commands\CreatePhpClassCode
{
    private function __construct(
        private string $className,
        private string $nameSpace,
        private Domain\Models\Properties $properties,
        private Domain\Models\Constances $constances,
        private array $methodsCode,
        private Domain\Models\NamespacesToImport $namespacesToImport
    ) {

    }

    public static function fromRequest(Adapters\Api\GeneratePhpClassRequest $request)
    {
        return new self(
            $request->className,
            is_null($request->subNamespace) ? $request->applicationNamespace : $request->applicationNamespace . "\\" . $request->subNamespace,
            Adapters\Models\Properties::fromSchema($request->jsonOjectSchema)->toDomain(),
            Adapters\Models\Constances::fromSchema($request->jsonOjectSchema)->toDomain(),
            $request->methodSourceCodeLines,
            Domain\Models\NamespacesToImport::fromArray($request->namespacesToImports)
        );
    }

    public function getProperties() : Domain\Models\Properties
    {
        return $this->properties;
    }

    public function getConstances() : Domain\Models\Constances
    {
        return $this->constances;
    }

    public function getNamespacesToImport() : Domain\Models\NamespacesToImport
    {
        return $this->namespacesToImport;
    }

    public function getMethodsCode() : array
    {
        return $this->methodsCode;
    }

    public function getClassName() : string
    {
        return $this->className;
    }

    public function getNamespace() : string
    {
        return $this->nameSpace;
    }
}
