<?php

namespace FluxEco\PhpClassGenerator\Core\Ports\Commands;
use FluxEco\PhpClassGenerator\Core\Domain\Models;

interface CreatePhpClassCode {
    public function getClassName(): string;
    public function getNamespace(): string;
    public function getProperties(): Models\Properties;
    public function getConstances(): Models\Constances;
    public function getMethodsCode(): array;
    public function getNamespacesToImport(): Models\NamespacesToImport;

}