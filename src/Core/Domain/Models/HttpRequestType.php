<?php

namespace FluxEco\PhpClassGenerator\Core\Domain\Models;

use function React\Promise\race;

enum HttpRequestType: string
{
    case GET = 'GET';
    case POST = 'POST';

}