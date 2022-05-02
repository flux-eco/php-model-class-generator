<?php

require_once __DIR__ . '/../vendor/autoload.php';

fluxPhpModelClassGenerator\generateModelClass(
    __DIR__ . '/accounts.yaml',
    'FluxCap\ExampleApp\Core\Domain\Models',
    __DIR__ . '/generated'
);