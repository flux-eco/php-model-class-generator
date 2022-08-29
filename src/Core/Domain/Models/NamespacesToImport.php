<?php

namespace FluxEco\PhpClassGenerator\Core\Domain\Models;

class NamespacesToImport
{

    /** @var string[] */
    private array $namespacesToImport = [];

    private function __construct()
    {

    }

    public static function new() : self
    {
        return new self();
    }

    public static function fromArray(array $namespacesToImport) : self
    {
        $self = new self();
        foreach ($namespacesToImport as $namespaceToImport) {
            $self->append($namespaceToImport);
        }
        return $self;
    }

    public function has() : bool
    {
        return (count($this->namespacesToImport) > 0);
    }

    public function append(string $namespaceToImport) : self
    {
        $this->namespacesToImport[] = $namespaceToImport;
        return $this;
    }

    public function get() : array
    {
        return $this->namespacesToImport;
    }
}