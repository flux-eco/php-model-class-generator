<?php

namespace FluxEco\PhpClassGenerator\Adapters\Models;

enum HttpServerOperationBindingKeyword: string {
    case METHOD = "method";
    case PATH = "path";
    case PATH_PARAMETERS = "path-parameters";
    case QUERY = "query";
    case HEADERS = "headers";
    case PAYLOAD = "payload";

    public static function getValueOrNullFromArray(array $data, self $keyword): string|int|array|null {
       return key_exists($keyword->value, $data)? $data[$keyword->value]: null;
    }
}