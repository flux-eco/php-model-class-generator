<?php

namespace FluxEco\PhpClassGenerator\Core\Domain\Models;


use Exception;

class ClassProperty
{

    private string $name;
    private string $type;
    private null|string|int $defaultValue;

    private function __construct(
        string $name,
        string $type,
        null|string|int $defaultValue = null
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->defaultValue = $defaultValue;
    }

    public static function new(
        string $key,
        string $type,
        null|string|int $defaultValue = null
    ) {
        return new self($key, $type, $defaultValue);
    }

    /**
     * @throws Exception
     */
    public static function fromJsonType(string $key, string $jsonType, ?string $defaultValue = null) : self
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
            case 'array':
                $type = 'array';
                break;
            case 'object':
                $type = ucfirst($key);
                break;
            default:
                $type = $jsonType;
                break;
               // throw new Exception($jsonType . ' could not be mapped to a PHP type');
               // break;
        }

        return new self($key, $type, $defaultValue);
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getType() : string
    {
        return $this->type;
    }

    public function getDefaultValue() : null|string|int
    {
        return $this->defaultValue;
    }
}