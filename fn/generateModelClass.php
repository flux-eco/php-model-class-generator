<?php

namespace fluxPhpModelClassGenerator;

use FluxEco\PhpModelClassGenerator;

function generateModelClass(string $schemaFilePath, string $nameSpace, string $targetDirectoryPath) : void
{
    PhpModelClassGenerator\Api::new()->generateModelClass($schemaFilePath, $nameSpace, $targetDirectoryPath);
}