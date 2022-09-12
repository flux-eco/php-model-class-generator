<?php

namespace FluxEco\PhpClassGenerator\Core\Domain;

use FluxEco\PhpClassGenerator\Core\Application;

class ServerDefinitionAggregate
{

    private function __construct(
        private Application\PhpCodeWriter $codeWriter,
        public readonly string $serverId,
        public readonly string $serverUrl,
        public readonly Models\ServerType $serverType,
        public readonly array $serverRequests
    ) {

    }

    public static function create(
        Application\PhpCodeWriter $codeWriter,
        string $serverId,
        string $serverUrl,
        Models\ServerType $serverType,
        array $serverRequests
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