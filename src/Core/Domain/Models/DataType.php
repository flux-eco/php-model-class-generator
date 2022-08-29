<?php

namespace FluxEco\PhpClassGenerator\Core\Domain\Models;


enum DataType: string
{
    case STRING = "string";
    case INTEGER = "integer";
    case FLOAT = "float";
    case BOOLEAN = "boolean";
    case ARRAY = "array";
    case OBJECT = "object";
    case NULL = "null";
    case RESOURCE = "resource";
}