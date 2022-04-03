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
        return new self($nameSpace, ucfirst($name));
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
        $this->appendLine('use JsonSerializable;', 2);
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
        $this->createNew();
        $this->createGetter();
        $this->createToJson();
        $this->createToArray();
        $this->createJsonSerialize();
        $this->appendLine('}', 0);
    }

    private function createNew()
    {
        $this->appendLine('public static function new(', 1, 1);
        foreach ($this->properties as $property) {
            $this->appendLine($property->getType() . ' $' . $property->getName() . ',', 1, 2);
        }
        $this->appendLine('): self {', 1, 1);

        $this->appendLine('return new self(', 1, 2);

        $properties = [];
        foreach ($this->properties as $property) {
            $properties[] = '$' .$property->getName();
        }
        $this->appendLine(implode(', ', $properties), 1, 3);
        $this->appendLine(');', 1, 2);
        $this->appendLine('}', 2, 1);
    }

    private function createConstructor()
    {
        $this->appendLine('private function __construct(', 1, 1);
        foreach ($this->properties as $property) {
            $this->appendLine($property->getType() . ' $' . $property->getName() . ',', 1, 2);
        }
        $this->appendLine(') {', 1, 1);
        foreach ($this->properties as $property) {
            $this->appendLine('$this->' . $property->getName() . ' = $' . $property->getName() . ';', 1, 2);
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

    private function createToArray()
    {
        $this->appendLine('final public function toArray(): array {', 1, 1);
        $this->appendLine('return get_object_vars($this);', 1, 2);
        $this->appendLine('}', 1, 1);
    }

    private function createJsonSerialize()
    {
        $this->appendLine('final public function jsonSerialize(): array {', 1, 1);
        $this->appendLine('return $this->toArray();', 1, 2);
        $this->appendLine('}', 1, 1);
    }

    private function appendLine(string $line, int $lineBreaksAfter, int $tabsBefore = 0)
    {
        $this->lines[] = str_repeat("\t", $tabsBefore);
        $this->lines[] = $line;
        $this->lines[] = str_repeat(PHP_EOL, $lineBreaksAfter);
    }
}