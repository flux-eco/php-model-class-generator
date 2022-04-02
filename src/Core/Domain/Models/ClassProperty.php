<?php

namespace FluxEco\PhpModelClassGenerator\Core\Domain\Models;

use Exception;

class ClassProperty
{

    private string $name;
    private string $type;

    private function __construct(
        string $name,
        string $type
    ) {
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @throws Exception
     */
    public static function fromJsonType(string $key, string $jsonType) : self
    {
        switch ($jsonType) {
            case 'string':
                $type = 'string';
                break;
            case 'integer':
                $type = 'int';
                break;
            case 'boolean':
                $type = 'bool';
                break;
            default:
                throw new Exception($jsonType . ' could not be mapped to a PHP type');
                break;
        }

        return new self($key, $type);
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getType() : string
    {
        return $this->type;
    }
}