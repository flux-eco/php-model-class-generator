<?php

namespace FluxEco\PhpClassGenerator\Adapters\Models;

enum JsonSchemaKeyword {
    case title;
    case properties;
    case type;
    case default;
    case const;
}