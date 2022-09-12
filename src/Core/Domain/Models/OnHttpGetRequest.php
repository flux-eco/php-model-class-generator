<?php

namespace FluxEco\PhpClassGenerator\Core\Domain\Models;

class OnHttpGetRequest {

    private function __construct(
        public readonly string $operationId,
        public readonly string $path,
        ?array $pathParameters = null,
        ?array $queryParameters = null
    ) {

    }

    public static function new(
        string $operationId,
        string $path,
        ?array $pathParametersDefinition = null,
        ?array $queryParametersDefinition = null
    ): self {

        $pathParameters = null;
        $queryParameters  = null;
        if(is_null($pathParametersDefinition) === false) {
            foreach($pathParametersDefinition as $parameterId => $schema) {
                $pathParameters[$parameterId] = ParameterDefinition::new($parameterId, $schema);
            }
        }
        if(is_null($queryParametersDefinition) === false) {
            foreach($queryParametersDefinition as $parameterId => $schema) {
                $queryParameters[$parameterId] = ParameterDefinition::new($parameterId, $schema);
            }
        }


        return new self(
            $operationId,
            $path,
            $pathParameters,
            $queryParameters
        );
    }
}