<?php

namespace FluxEco\PhpClassGenerator\Adapters\Models;

use FluxEco\PhpClassGenerator\Core\Domain\Models;

class Constances
{

    private function __construct(private readonly array $jsonOjectSchema = [])
    {

    }

    public static function fromSchema(array $jsonOjectSchema = []) : self
    {
        return new self($jsonOjectSchema);
    }

    public function toDomain() : Models\Constances
    {
        $constants = Models\Constances::new();
        if (array_key_exists(JsonSchemaKeyword::properties->name, $this->jsonOjectSchema)) {
            foreach ($this->jsonOjectSchema[JsonSchemaKeyword::properties->name] as $key => $property) {
                if (array_key_exists(JsonSchemaKeyword::const->name, $property) === false) {
                    continue;
                }
                $constants->append(Models\Constance::new($key, $property[JsonSchemaKeyword::const->name]));
            }
        }
        return $constants;
    }

}