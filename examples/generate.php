<?php

require_once __DIR__ . '/../vendor/autoload.php';

$phpSourceCodeGenerator = FluxEco\PhpClassGenerator\Api::new();

$jsonSchema =  yaml_parse(file_get_contents(__DIR__ . '/Account.yaml'));
$className = $jsonSchema['title'];
$sourceCodeLines = $phpSourceCodeGenerator->generatePhpClass(
    FluxEco\PhpClassGenerator\Adapters\Api\GeneratePhpClassRequest::new(
        "FluxEco\\ExampleApp",
        $className,
        "Core\\Domain\\Models",
        $jsonSchema,
    )
);
file_put_contents(__DIR__ . "/generated/app/src/Core/Domain/Models/".$className.".php",  $sourceCodeLines);


$jsonSchema =  yaml_parse(file_get_contents(__DIR__ . '/Account.yaml'))[\FluxEco\PhpClassGenerator\Adapters\Models\JsonSchemaKeyword::properties->name]['lastChanged'];
$className = $jsonSchema['title'];
$sourceCodeLines = $phpSourceCodeGenerator->generatePhpClass(
    FluxEco\PhpClassGenerator\Adapters\Api\GeneratePhpClassRequest::new(
        "FluxEco\\ExampleApp",
        $className,
        "Core\\Domain\\Models",
        $jsonSchema
    )
);
file_put_contents(__DIR__ . "/generated/app/src/Core/Domain/Models/".$className.".php",  $sourceCodeLines);