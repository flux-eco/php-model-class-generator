<?php

namespace FluxEco\PhpClassGenerator\Adapters\Models;

use FluxEco\PhpClassGenerator\Core\Domain\Models;

class Properties
{

    private function __construct(private readonly array $jsonOjectSchema = [])
    {

    }

    public static function fromSchema(array $jsonOjectSchema = []) : self
    {
        return new self($jsonOjectSchema);
    }

    public function toDomain() : Models\Properties
    {
        $properties = Models\Properties::new(false);
        if (array_key_exists(JsonSchemaKeyword::properties->name, $this->jsonOjectSchema)) {
            foreach ($this->jsonOjectSchema[JsonSchemaKeyword::properties->name] as $key => $jsonProperty) {
                if (array_key_exists(JsonSchemaKeyword::const->name, $jsonProperty)) {
                    continue;
                }
                $properties->append(
                    Models\Property::new(
                        $key,
                        JsonSchemaType::from($jsonProperty[JsonSchemaKeyword::type->name])->toDomain($jsonProperty),
                        array_key_exists(JsonSchemaKeyword::default->name,
                            $jsonProperty) ? $jsonProperty[JsonSchemaKeyword::default->name] : null
                    )
                );
            }
        }
        return $properties;
    }

}