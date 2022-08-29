<?php

namespace FluxEco\PhpClassGenerator\Adapters;
use FluxEco\PhpClassGenerator\{Adapters, Core\Domain, Core\Ports};

class Outbounds implements Ports\Outbounds
{

    private function __construct()
    {

    }

    public static function new() : self
    {
        return new self();
    }
}