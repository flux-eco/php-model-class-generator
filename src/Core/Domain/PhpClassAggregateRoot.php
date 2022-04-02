<?php

namespace FluxEco\PhpModelClassGenerator\Core\Domain;

class PhpClassAggregateRoot
{
    private string $name;
    private array $lines;

    /** @param Models\ClassProperty[] */
    private array $properties;

    private function __construct(string $nameSpace, string $name)
    {
        $this->appendLine('<?php', 1);
        $this->applyNameSpace($nameSpace);
        $this->applyName($name);
    }

    public static function new(string $nameSpace, string $name)
    {
        return new self($nameSpace, $name);
    }

    public function addProperty(string $key, string $jsonType)
    {
        $this->applyProperty(Models\ClassProperty::fromJsonType($key, $jsonType));
    }

    public function getClassLines(): array
    {

        $this->applyAllPropertiesSet();
        return $this->lines;
    }

    private function applyName(string $name)
    {
        $this->appendLine('class ' . $name . ' implements JsonSerializable {', 2);
        $this->name = $name;
    }

    public function getName() : string
    {
        return $this->name;
    }

    private function applyNameSpace(string $nameSpace)
    {
        $this->appendLine('namespace ' . $nameSpace . ';', 2);
    }

    private function applyProperty(Models\ClassProperty $property)
    {
        $this->appendLine('private ' . $property->getType() . ' $' . $property->getName() . ';', 2, 1);
        $this->properties[$property->getName()] = $property;
    }

    private function applyAllPropertiesSet() : void
    {
        $this->createConstructor();
        $this->createGetter();
        $this->createToJson();
        $this->createJsonSerialize();
        $this->appendLine('}', 0);
    }

    private function createConstructor()
    {
        $this->appendLine('public function __construct(', 1, 1);
        foreach ($this->properties as $property) {
            $this->appendLine($property->getType() . ' $' . $property->getName() . ',', 1, 2);
        }
        $this->appendLine('): {', 1, 1);
        foreach ($this->properties as $property) {
            $this->appendLine('$obj->' . $property->getName() . ' = $' . $property->getName() . ';', 1, 2);
        }
        $this->appendLine('}', 2, 1);
    }

    private function createGetter()
    {
        foreach ($this->properties as $property) {
            $this->appendLine('final public function get' . ucfirst($property->getName()) . '(): ' . $property->getType() . ' {',
                1, 1);
            $this->appendLine('return $this->' . $property->getName() . ';', 1, 2);
            $this->appendLine('}', 2, 1);
        }
    }

    private function createToJson()
    {
        $this->appendLine('final public function toJson(): string {', 1, 1);
        $this->appendLine('return json_encode($this, JSON_THROW_ON_ERROR);', 1, 2);
        $this->appendLine('}', 2, 1);
    }

    private function createJsonSerialize()
    {
        $this->appendLine('final public function jsonSerialize(): array {', 1, 1);
        $this->appendLine('return get_object_vars($this);', 1, 2);
        $this->appendLine('}', 1, 1);
    }

    private function appendLine(string $line, int $lineBreaksAfter, int $tabsBefore = 0)
    {
        $this->lines[] = str_repeat("\t", $tabsBefore);
        $this->lines[] = $line;
        $this->lines[] = str_repeat(PHP_EOL, $lineBreaksAfter);
    }
}