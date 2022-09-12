<?php

namespace FluxEco\PhpClassGenerator\Core\Domain\Models;

class OnHttpPostRequest {

    private function __construct(
        public readonly string $operationId,
        public readonly string $path,
        ?array $pathParametersDefinition = null,
        ?array $payloadDefinition = null
    ) {

    }

    public static function new(
        string $operationId,
        string $path,
        ?array $pathParametersSchema = null,
        ?array $queryParametersSchema = null
    ): self {

        $pathParametersDefinition = null;
        $payloadDefinition  = null;
        if(is_null($pathParametersSchema) === false) {
            foreach($pathParametersSchema as $parameterId => $schema) {
                $pathParametersDefinition[$parameterId] = ParameterDefinition::new($parameterId, $schema);
            }
        }
        if(is_null($queryParametersSchema) === false) {
            foreach($queryParametersSchema as $parameterId => $schema) {
                $payloadDefinition[$parameterId] = ParameterDefinition::new($parameterId, $schema);
            }
        }


        return new self(
            $operationId,
            $path,
            $pathParametersDefinition,
            $payloadDefinition
        );
    }
}