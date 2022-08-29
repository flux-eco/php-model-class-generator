<?php

namespace FluxEco\PhpClassGenerator\Core\Domain;

class RootObject
{
    private array $lines;
    /** @param Models\ClassProperty[] */
    private array $properties = [];
    public bool $allowAdditionalProperties = true;

    private function __construct()
    {

    }

    public static function new()
    {
        return new self();
    }

    /* public function addConst(string $key, null|string|int $value)
     {
         $this->applyProperty(Models\ClassProperty::new($key, 'const', $value));
     }
    */

    public function addProperty(string $key, string $jsonType, null|string|int $defaultValue = null)
    {
        $property = Models\ClassProperty::fromJsonType($key, $jsonType, $defaultValue);
        $this->properties[$property->getName()] = $property;
    }

    private function createLinesProperties()
    {
        foreach($this->properties as $property) {
            if ($property->getName() !== "additionalProperties") {
                if ($property->getDefaultValue() !== null) {
                    if ($property->getType() === "const") {
                        if (is_int($property->getDefaultValue())) {
                            $this->appendLine('public int $' . $property->getName() . ' = ' . $property->getDefaultValue() . ';',
                                2, 1);
                        } else {
                            $this->appendLine('public string $' . $property->getName() . ' = "' . $property->getDefaultValue() . '";',
                                2, 1);
                        }
                    } else {
                        //todo readonly with php 8.1
                        $this->appendLine('public ' . $property->getType() . ' $' . $property->getName() . ' = ' . $property->getDefaultValue() . ';',
                            2, 1);
                    }

                } else {
                    //$this->appendLine('public ' . $property->getType() . ' $' . $property->getName() . ';', 2, 1);
                }
            }
        }

    }

    public function getModelClassLines(
        string $className,
        string $namespace,
        array $use = [],
        array $addtionalLines = [],
        array $publicConstants = []
    ) : array {

        $this->createLinesHead();
        $this->createLinesNameSpace($namespace);
        $this->createLinesUse($use);
        $this->createLinesClassName($className, true);
        if (count($publicConstants) > 0) {
            $this->createLinesPublicConstances($publicConstants);
        }
        $this->createLinesProperties();
        $this->createLinesConstructor();
        $this->createLinesNew();

        $this->createLinesFromArray();
        $this->createLinesToJson();
        $this->createLinesToArray();
        $this->createLinesJsonSerialize();

        $lines = array_merge($this->lines, $addtionalLines, ["}"]);
        return $lines;
    }

    public function getServiceClassLines(
        string $className,
        string $namespace,
        array $use = [],
        array $addtionalLines = [],
        array $publicConstants = []
    ) : array {

        $this->createLinesHead();
        $this->createLinesNameSpace($namespace);
        $this->createLinesUse($use);
        $this->createLinesClassName($className, false);
        if (count($publicConstants) > 0) {
            $this->createLinesPublicConstances($publicConstants);
        }
        $this->createLinesConstructor();
        $this->createLinesNew();

        $lines = array_merge($this->lines, $addtionalLines, ["}"]);
        return $lines;
    }

    private function createLinesClassName(string $name, bool $isJsonSerializable) : void
    {
        if ($isJsonSerializable) {
            $this->appendLine('use JsonSerializable;', 2);
            $this->appendLine('class ' . $name . ' implements JsonSerializable {', 2);
        } else {
            $this->appendLine('class ' . $name . ' {', 2);
        }
    }

    private function createLinesNameSpace(string $nameSpace)
    {
        $this->appendLine('namespace ' . $nameSpace . ';', 2);
    }

    private function createLinesUse(array $use)
    {
        if (count($use) > 0) {
            foreach ($use as $line) {
                $this->appendLine($line, 1);
            }
        }
        $this->appendLine("", 1);
    }

    private function createLinesPublicConstances(array $publicConstants = []) : void
    {
        if (count($publicConstants) > 0) {
            foreach ($publicConstants as $name => $value) {
                $this->appendLine('public const ' . $name . ' = "' . $value . '";', 2, 1);
            }
        }
    }

    private function createLinesNew()
    {
        $this->appendLine('public static function new(', 1, 1);
        foreach ($this->properties as $property) {
            if ($property->getName() === "properties") {
                continue;
            }

            if ($property->getType() === "const") {
                continue;
            }

            if ($property->getDefaultValue()) {

                if($property->getDefaultValue() === 'null') {
                    $this->appendLine("?".$property->getType() . ' $' . $property->getName() . ' = ' . $property->getDefaultValue() . ',',
                        1, 2);
                } else {
                    $this->appendLine($property->getType() . ' $' . $property->getName() . ' = ' . $property->getDefaultValue() . ',',
                        1, 2);
                }


            } else {
                $this->appendLine($property->getType() . ' $' . $property->getName() . ',', 1, 2);
            }
        }
        if($this->allowAdditionalProperties) {
            $this->appendLine('array $additionalProperties = []', 1, 2);
        }
        $this->appendLine('): self {', 1, 1);

        $this->appendLine('return new self(', 1, 2);

        $properties = [];
        foreach ($this->properties as $property) {
            if ($property->getName() === "properties") {
                continue;
            }
            if ($property->getType() === "const") {
                continue;
            }
            $properties[] = '$' . $property->getName();
        }

        foreach ($properties as $property) {
            $this->appendLine($property . ',', 1, 3);
        }
        if($this->allowAdditionalProperties) {
            $this->appendLine('$additionalProperties', 1, 3);
        }

        $this->appendLine(');', 1, 2);
        $this->appendLine('}', 2, 1);
    }

    private function createLinesHead() : void
    {
        $this->appendLine('<?php', 1);
        $this->appendLine('/* This is an automated generated class by flux-eco/php-class-generator */', 1);
    }

    private function createLinesConstructor()
    {
        $this->appendLine('private function __construct(', 1, 1);
        foreach ($this->properties as $property) {
            if ($property->getName() === "properties") {
                continue;
            }

            if ($property->getType() === "const") {
                continue;
            }

            if ($property->getDefaultValue() !== null) {
                if($property->getDefaultValue() === 'null') {
                    $this->appendLine('public ?' . $property->getType() . ' $' . $property->getName() . ' = ' . $property->getDefaultValue() . ',',
                        1, 2);
                } else {
                    $this->appendLine('public ' . $property->getType() . ' $' . $property->getName() . ' = ' . $property->getDefaultValue() . ',',
                        1, 2);
                }
            } else {
                $this->appendLine('public ' . $property->getType() . ' $' . $property->getName() . ',', 1, 2);
            }
        }
        if($this->allowAdditionalProperties) {
            $this->appendLine('public array $additionalProperties = []', 1, 2);
        }

        $this->appendLine(') {', 1, 1);
        foreach ($this->properties as $property) {
            if ($property->getName() === "properties") {
                continue;
            }

            if ($this->allowAdditionalProperties && $property->getName() === "additionalProperties") {
                $this->appendLine('if(count($additionalProperties) > 0) {', 1, 2);
                $this->appendLine('foreach($additionalProperties as $propertyKey => $propertyValue) {', 1, 4);
                $this->appendLine('$this->properties[$propertyKey] = $propertyValue;', 1, 6);
                $this->appendLine('}', 1, 4);
                $this->appendLine('}', 1, 2);
            } else {
                if ($property->getType() === "const") {
                    $this->appendLine('$this->properties["' . $property->getName() . '"] = $this->' . $property->getName() . ';',
                        1, 2);
                    continue;
                }

                //$this->appendLine('$this->' . $property->getName() . ' = $' . $property->getName() . ';', 1, 2);
                $this->appendLine('$this->properties["' . $property->getName() . '"] = $' . $property->getName() . ';',
                    1, 2);
            }
        }
        if($this->allowAdditionalProperties) {
            $this->appendLine('if(count($additionalProperties) > 0) {', 1, 2);
            $this->appendLine('foreach($additionalProperties as $propertyKey => $propertyValue) {', 1, 4);
            $this->appendLine('$this->$propertyKey = $propertyValue;', 1, 6);
            $this->appendLine('}', 1, 4);
            $this->appendLine('}', 1, 2);
        }

        $this->appendLine('}', 1, 1);
    }

    private function createLinesFromArray()
    {
        $this->appendLine('public static function fromArray(', 1, 1);
        $this->appendLine('array $keyValueData',
            1, 2);
        $this->appendLine('): self {', 1, 1);
        if($this->allowAdditionalProperties) {
            $this->appendLine('$fromArray = ["additionalProperties" => []];', 1, 3);
        }

        foreach ($this->properties as $key => $property) {
            if ($property->getType() === "const") {
                continue;
            }
            if (in_array($property->getName(), ["properties", "additionalProperties"])) {
                continue;
            }

            $this->appendLine('if(key_exists("' . $property->getName() . '", $keyValueData) === true) {', 1, 3);

            if (in_array($property->getType(), ['int', 'string', 'boolean', 'array'])) {
                $this->appendLine('$fromArray["' . $property->getName() . '"] = $keyValueData["' . $key . '"];', 1, 5);
            } elseif ($property->getType() === "object") {
                $this->appendLine('$fromArray["' . $property->getName() . '"] =  json_decode(json_encode($keyValueData["' . $key . '"]));',
                    1, 5);
            } else {
                $this->appendLine('$fromArray["' . $property->getName() . '"] = ' . $property->getType() . '::new($keyValueData["' . $key . '"]);',
                    1, 5);
            }
            if($this->allowAdditionalProperties) {
                $this->appendLine('} else {', 1, 5);
                $this->appendLine('$fromArray["additionalProperties"]["' . $property->getName() . '"] = $keyValueData["' . $key . '"];',
                    1, 5);
            }
            $this->appendLine('}', 1, 4);

        }
        if($this->allowAdditionalProperties) {
            $this->appendLine('$fromArray["additionalProperties"] = array_merge($fromArray["additionalProperties"], $keyValueData);',
                1, 5);
        }

        $this->appendLine('return call_user_func_array("self::new", $fromArray);', 1, 3);
        $this->appendLine('}', 2, 1);
    }

    private function createLinesToJson()
    {
        $this->appendLine('final public function toJson(): string {', 1, 1);
        $this->appendLine('return json_encode($this, JSON_THROW_ON_ERROR);', 1, 2);
        $this->appendLine('}', 2, 1);
    }

    public function createLinesToArray()
    {
        $this->appendLine('final public function toArray(): array {', 1, 1);

        $this->appendLine('$vars = get_object_vars($this);', 1, 2);
        if($this->allowAdditionalProperties) {
            $this->appendLine('unset($vars["additionalProperties"]);', 1, 2);
        }
        //

        $this->appendLine('return json_decode(json_encode( $vars ),true);', 1, 2);
        $this->appendLine('}', 1, 1);
    }

    private function createLinesJsonSerialize()
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