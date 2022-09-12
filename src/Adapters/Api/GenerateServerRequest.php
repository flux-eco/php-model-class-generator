<?php

namespace FluxEco\PhpClassGenerator\Adapters\Api;

use FluxEco\PhpClassGenerator\Adapters;
use FluxEco\PhpClassGenerator\Core\Domain;

class GenerateServerRequest
{
    private array $requestDefinitions = [];

    private function __construct(
        public string $serverId,
        public string $serverUrl,
        public Domain\Models\ServerType $serverType
    )
    {

    }

    public static function fromHttpOperationBinding(string $serverId, string $serverUrl, array $operationBindings): self
    {
        $new = new self($serverId, $serverUrl, Domain\Models\ServerType::HTTP);
        foreach ($operationBindings as $operationId => $binding) {
            switch ($binding[Adapters\Models\HttpServerOperationBindingKeyword::METHOD->value]) {
                case Domain\Models\HttpRequestType::GET->value:
                    $new->addOnGETRequestOperation(
                        $operationId,
                        Adapters\Models\HttpServerOperationBindingKeyword::getValueOrNullFromArray($binding, Adapters\Models\HttpServerOperationBindingKeyword::PATH),
                        Adapters\Models\HttpServerOperationBindingKeyword::getValueOrNullFromArray($binding, Adapters\Models\HttpServerOperationBindingKeyword::PATH_PARAMETERS),
                        Adapters\Models\HttpServerOperationBindingKeyword::getValueOrNullFromArray($binding, Adapters\Models\HttpServerOperationBindingKeyword::QUERY)
                    );
                    break;
                case Domain\Models\HttpRequestType::POST->value:
                    $new->addOnPOSTRequestOperation(
                        $operationId,
                        Adapters\Models\HttpServerOperationBindingKeyword::getValueOrNullFromArray($binding, Adapters\Models\HttpServerOperationBindingKeyword::PATH),
                        Adapters\Models\HttpServerOperationBindingKeyword::getValueOrNullFromArray($binding, Adapters\Models\HttpServerOperationBindingKeyword::PATH_PARAMETERS),
                        Adapters\Models\HttpServerOperationBindingKeyword::getValueOrNullFromArray($binding, Adapters\Models\HttpServerOperationBindingKeyword::PAYLOAD)
                    );
            }
        }
        return $new;
    }

    public function toCommand(): Adapters\Commands\CreatePhpServerCode  {
        return  Adapters\Commands\CreatePhpServerCode::fromRequest($this);
    }

    public function getRequestDefinitions(): array {
        return $this->requestDefinitions;
    }


    private function addOnGETRequestOperation(string $operationId, string $path, ?array $pathParametersSchema = null, ?array $queryParametersSchema = null): self
    {
        $this->requestDefinitions[] = Domain\Models\OnHttpGetRequest::new($operationId, $path, $pathParametersSchema, $queryParametersSchema);
        return $this;
    }

    private function addOnPOSTRequestOperation(string $operationId, string $path, ?array $pathParametersSchema = null, ?array $payloadSchema = null): self
    {
        $this->requestDefinitions[] = Domain\Models\OnHttpPostRequest::new($operationId, $path, $pathParametersSchema, $payloadSchema);
        return $this;
    }

}