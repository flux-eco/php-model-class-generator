<?php

namespace FluxEco\PhpClassGenerator\Core\Domain\Models;

class Properties {

    /** @var Property[] */
    private array $properties = [];

    private function __construct(
        public readonly bool $allowAdditionalProperties
    ) {

    }

    public static function new($allowAdditionalProperties = false): self {
        return new self($allowAdditionalProperties);
    }

    public function has(): bool {
        return (count($this->properties) > 0);
    }

    public function append(Property $property): self {
        $this->properties[] = $property;
        return $this;
    }

    public function get(): array {
        return $this->properties;
    }
}