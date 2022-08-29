<?php

namespace FluxEco\PhpClassGenerator\Core\Domain;

class Aggregate
{
    private function __construct(
        private RootObject $rootObject
    ) {

    }

    public static function new(): self
    {
        return new self(RootObject::new());
    }

    public function createModelClassLines(
        string $className,
        string $nameSpace,
        array $objectSchema,
        array $use = [],
        array $additionalLines = [],
        array $public_constants = []
    ) : array {

        $this->addPropertiesFromSchemaToRootObject($objectSchema);

        return $this->rootObject->getModelClassLines(
            $className,
            $nameSpace,
            $use,
            $additionalLines,
            $public_constants
        );

    }

    public function createServiceClassLines(
        string $className,
        string $nameSpace,
        array $objectSchema,
        array $use = [],
        array $additionalLines = [],
        array $public_constants = []
    ) : array {
        $this->addPropertiesFromSchemaToRootObject($objectSchema);
        $this->rootObject->allowAdditionalProperties = false;
        return $this->rootObject->getServiceClassLines(
            $className,
            $nameSpace,
            $use,
            $additionalLines,
            $public_constants
        );
    }

    private function addPropertiesFromSchemaToRootObject(array $objectSchema) : void
    {
        if (key_exists('properties', $objectSchema)) {
            foreach ($objectSchema['properties'] as $key => $schema) {
                if (is_array($schema)) {
                    if(key_exists('type', $schema)) {
                        $type = $schema['type'];
                        if (is_array($type) && in_array('null', $type) && in_array('object', $type)) {
                            $type = ucfirst($key) . "|" . 'null';
                        } else {
                            $this->rootObject->addProperty($key, $type,
                                key_exists('defaultValue', $schema) ? $schema['defaultValue'] : null);
                        }
                    }

                    if (key_exists('const', $schema)) {
                        $this->rootObject->addProperty($key, 'const', $schema['const']);
                    }
                }
            }
        }
    }
}