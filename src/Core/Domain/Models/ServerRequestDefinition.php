<?php

namespace FluxEco\PhpClassGenerator\Core\Domain\Models;

interface ServerRequestDefinition {
    public function getRequestType(): string;
    public function getContext(): string;
    public function getParameterIds(): array;
    public function getOperationId(): string;
}