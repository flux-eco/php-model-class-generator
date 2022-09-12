<?php

namespace FluxEco\PhpClassGenerator\Core\Application;

use FluxEco\PhpClassGenerator\Core\Domain\Models;

interface PhpServerWriter
{

    public function writeOnStart(): void;

    public function writeOnShutdown(string $namespace);

    /** @poram Models\ServerRequest[] */
    public function writeOnRequest(string $serverUrl, Models\ServerDefinition $serverRequests);

    public function writeAdditionalLines(array $lines);


}