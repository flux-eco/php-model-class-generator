<?php

namespace FluxEco\PhpClassGenerator\Core\Domain\Models;

class Constances {

    /** @var Constance[] */
    private array $constances = [];

    private function __construct() {

    }

    public static function new(): self {
        return new self();
    }

    public function has(): bool {
        return (count($this->constances) > 0);
    }

    public function append(Constance $constance): self {
        $this->constances[] = $constance;
        return $this;
    }

    public function get(): array {
        return $this->constances;
    }
}