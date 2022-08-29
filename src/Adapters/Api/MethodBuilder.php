<?php

namespace FluxEco\PhpClassGenerator\Adapters\Api;

class MethodBuilder
{
    private $lines;
    private string $name;
    private string $returnType;
    private string $visibility;
    private array $parameters = [];
    private array $bodyLines = [];

    private function __construct(string $name, string $returnType, string $visibility)
    {
        $this->name = $name;
        $this->returnType = $returnType;
        $this->visibility = $visibility;
    }

    public static function newPrivateMethod($name, string $returnType) : self
    {
        $visibility = "private";
        return new self($name, $returnType, $visibility);
    }

    public static function newPublicMethod($name, string $returnType) : self
    {
        $visibility = "public";
        return new self($name, $returnType, $visibility);
    }

    public static function newPublicStaticMethod($name, string $returnType) : self
    {
        $visibility = "public static";
        return new self($name, $returnType, $visibility);
    }

    public function addParameter($name, string $type, null|string|int $defaultValue = null) : self
    {
        $parameter = $type . " $" . $name;
        if ($defaultValue !== null) {
            //todo
            if($defaultValue === 'null') {
                $parameter = $parameter . " = null";
            } else {
                $parameter = $parameter . " = " . $defaultValue;
            }
        }
        $this->parameters[] = $parameter;
        return $this;
    }

    public function addBodyLine(string $line, int $lineBreaksAfter = 1, int $tabsBefore = 0) : self
    {
        $this->bodyLines[] = str_repeat("\t", $tabsBefore);
        $this->bodyLines[] = $line;
        $this->bodyLines[] = str_repeat(PHP_EOL, $lineBreaksAfter);
        return $this;
    }

    public function build() : array
    {
        $this->appendLine("", 1, 0);

        if(count($this->parameters) > 0) {
            $this->appendLine($this->visibility . " function " . $this->name . "(".implode(", ",$this->parameters).") :" . $this->returnType . " {", 1, 1);
        } else {
            $this->appendLine($this->visibility . " function " . $this->name . "(".implode(", ",$this->parameters).") :" . $this->returnType . " {", 1, 1);
        }


        $this->lines = array_merge($this->lines,$this->bodyLines);


        $this->appendLine("}", 1, 1);
        return $this->lines;
    }

    private function appendLine(string $line, int $lineBreaksAfter, int $tabsBefore = 0)
    {
        $this->lines[] = str_repeat("\t", $tabsBefore);
        $this->lines[] = $line;
        $this->lines[] = str_repeat(PHP_EOL, $lineBreaksAfter);
    }

}