<?php

require_once __DIR__ . '/../vendor/autoload.php';

$modelClassGenerator = FluxEco\PhpModelClassGenerator\PhpModelClassGeneratorApi::new();
$modelClassGenerator->generateModelClass(
    __DIR__ . '/accounts.yaml',
    'FluxCap\ExampleApp\Core\Domain\Models',
    '/tmp'
);