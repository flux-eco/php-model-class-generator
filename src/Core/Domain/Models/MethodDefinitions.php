<?php

namespace FluxEco\PhpClassGenerator\Core\Domain\Models;

class MethodDefinitions
{

    private array $methodDefinitions = [];

    private function __construct()
    {

    }

    public static function new() : self
    {
        return new self();
    }

    public function appendMethodDefinition(MethodDefinition $methodDefinition) : self
    {
        $this->methodDefinitions[] = $methodDefinition;
        return $this;
    }
}