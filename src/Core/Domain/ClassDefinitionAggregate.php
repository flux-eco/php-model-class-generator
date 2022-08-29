<?php

namespace FluxEco\PhpClassGenerator\Core\Domain;

use FluxEco\PhpClassGenerator\Core\Application;

class ClassDefinitionAggregate
{

    private function __construct(
        private Application\PhpCodeWriter $codeWriter,
        public readonly string $className,
        public readonly string $namespace,
        public readonly Models\Properties $properties,
        public readonly Models\NamespacesToImport $namespacesToImport,
        public readonly Models\Constances $constances,
        public array $additionalCodeLines
    ) {

    }

    public static function create(
        Application\PhpCodeWriter $codeWriter,
        string $className,
        string $namespace,
        Models\Properties $properties,
        Models\NamespacesToImport $namespacesToImport,
        Models\Constances $constances,
        $additionalCodeLines
    ) : self {
        return new self(...get_defined_vars());
    }

    public function writeCode() : array
    {
        $this->codeWriter->writeFileHeader();
        $this->codeWriter->writeNamepace($this->namespace);
        $this->codeWriter->writeNamespacesToImport($this->namespacesToImport);
        $this->codeWriter->writeClassHeader($this->className, false);
        $this->codeWriter->writePublicConstances($this->constances);
        $this->codeWriter->writeClassConstructor($this->properties);
        $this->codeWriter->writeStaticClassMethodNew($this->properties);
        $this->codeWriter->writeAdditionalLines($this->additionalCodeLines);

        $this->codeWriter->writeFileFooterLines();

        return $this->codeWriter->lines;
    }
}