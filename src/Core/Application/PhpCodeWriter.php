<?php

namespace FluxEco\PhpClassGenerator\Core\Application;

use FluxEco\PhpClassGenerator\Core\Domain\Models;

use Laminas\Db\Module;

class PhpCodeWriter
{

    private function __construct(
        public array $lines = []
    ) {

    }

    public static function new() : self
    {
        return new self();
    }

    public function writeFileHeader() : void
    {
        $this->writeLine('<?php', 1);
        $this->writeLine('/* This is an automated generated class by flux-eco/php-class-generator */', 1);
    }

    public function writeNamepace(string $namespace)
    {
        $this->writeLine('namespace ' . $namespace . ';', 2);
    }

    public function writeNamespacesToImport(Models\NamespacesToImport $namespaceImports)
    {
        if ($namespaceImports->has()) {
            foreach ($namespaceImports->get() as $namespace) {
                $this->writeLine('use ' . $namespace . ';', 1);
            }
        }
        $this->writeLine("", 1);
    }

    public function writeClassHeader(string $name, bool $isJsonSerializable) : void
    {
        if ($isJsonSerializable) {
            $this->writeLine('use JsonSerializable;', 2);
            $this->writeLine('class ' . $name . ' implements JsonSerializable {', 2);
        } else {
            $this->writeLine('class ' . $name . ' {', 2);
        }
    }

    public function writePublicConstances(Models\Constances $publicConstances) : void
    {
        if ($publicConstances->has()) {
            foreach ($publicConstances->get() as $constance) {
                $this->writeLine('public const ' . $constance->name . ' = "' . $constance->value . '";', 2, 1);
            }
        }
        $this->writeLine("", 1);
    }

    public function writeClassConstructor(
        Models\Properties $properties
    ) : void {
        $this->writeLine('private function __construct(', 1, 1);

        if ($properties->has()) {
            foreach ($properties->get() as $property) {
                if ($property->hasDefaultValue()) {
                    $this->writeLine('public ?' . $property->type . ' $' . $property->key . ' = ' . $property->default . ',',
                        1, 2);
                } else {
                    $this->writeLine('public ' . $property->type . ' $' . $property->key . ',', 1, 2);
                }
            }
        }
        if ($properties->allowAdditionalProperties) {
            $this->writeLine('public array $additionalProperties = []', 1, 2);
        }
        $this->writeLine(') {', 1, 1);

        if ($properties->allowAdditionalProperties) {
            $this->writeLine('if(count($additionalProperties) > 0) {', 1, 2);
            $this->writeLine('foreach($additionalProperties as $propertyKey => $propertyValue) {', 1, 4);
            $this->writeLine('$this->properties[$propertyKey] = $propertyValue;', 1, 6);
            $this->writeLine('}', 1, 4);
            $this->writeLine('}', 1, 2);
        }

        if ($properties->has()) {
            foreach ($properties->get() as $property) {
                $this->writeLine('$this->properties["' . $property->key . '"] = $' . $property->key . ';',
                    1, 2);
            }
        }

        $this->writeLine('}', 1, 1);
    }

    public function writeStaticClassMethodNew(
        Models\Properties $properties
    ) {
        $this->writeLine('public static function new(', 1, 1);
        if ($properties->has()) {
            foreach ($properties->get() as $property) {
                if ($property->hasDefaultValue()) {
                    $this->writeLine($property->type . ' $' . $property->key . ' = ' . $property->default . ',',
                        1, 2);

                } else {
                    $this->writeLine($property->type . ' $' . $property->key . ',', 1, 2);
                }
            }
            if ($properties->allowAdditionalProperties) {
                $this->writeLine('array $additionalProperties = []', 1, 2);
            }
        }
        $this->writeLine('): self {', 1, 1);

        $this->writeLine('return new self(', 1, 2);

        if ($properties->has()) {
            $propertiesToAppend = [];
            foreach ($properties->get() as $property) {
                $propertiesToAppend[] = '$' . $property->key;
            }

            foreach ($propertiesToAppend as $property) {
                $this->writeLine($property . ',', 1, 3);
            }
        }

        if ($properties->allowAdditionalProperties) {
            $this->writeLine('$additionalProperties', 1, 3);
        }
        $this->writeLine(');', 1, 2);
        $this->writeLine('}', 2, 1);
    }

    public function writeAdditionalLines(array $lines)
    {
        $this->lines = array_merge($this->lines, $lines);
    }

    public function writeFileFooterLines() : void
    {
        $this->writeLine('}', 0);
    }

    private function writeLine(string $line, int $lineBreaksAfter, int $tabsBefore = 0)
    {
        $this->lines[] = str_repeat("\t", $tabsBefore);
        $this->lines[] = $line;
        $this->lines[] = str_repeat(PHP_EOL, $lineBreaksAfter);
    }

}