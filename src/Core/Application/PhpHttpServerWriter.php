<?php

namespace FluxEco\PhpClassGenerator\Core\Application;

use FluxEco\PhpClassGenerator\Core\Domain\Models;


class PhpHttpServerWriter implements PhpServerWriter
{

    public function writeOnStart() : void
    {
        $this->writeLine('$server->on("Start", function (\Swoole\Http\Server $server) use ($asyncApi) {', 1);
        $this->writeLine('echo PHP_EOL . PHP_EOL;', 1, 2);
        $this->writeLine("echo PHP_EOL . 'SERVER HAS STARTET' . PHP_EOL;", 1, 2);
        $this->writeLine("echo PHP_EOL . PHP_EOL;", 1, 2);
        $this->writeLine(" });", 1);
    }

    public function writeOnShutdown(string $namespace)
    {
        $this->writeLine('$server->on("Shutdown", function ($serv) {', 1);
        $this->writeLine('echo "Shutdown" . PHP_EOL;', 1, 2);
        $this->writeLine(" });", 1);
    }

    /**
     * @param Models\ServerDefinition
     * @return void
     */
    public function writeOnRequest(string $serverUrl, Models\ServerDefinition $serverRequestDefinitions)
    {
        $this->writeLine('$onRequest = function (Swoole\Http\Request $request, Swoole\Http\Response $response) use ($asyncApi, $server) {', 1);
        $this->writeLine('$path = explode($serverUrl, $request->server["request_uri"])[1];', 1, 2);
        $this->writeLine('$pathFragments =  explode("/", $path);', 1, 2);
        $this->writeLine('$requestType = $request->server["request_method"]', 1, 2);
        $this->writeLine('on".$requestType.$pathFragments[0]."(array_slice($pathFragments, 1), $response)',1,2);
        $this->writeLine("});", 2);

        $this->writeOnRequestContexts($serverRequestDefinitions);
    }

    private function writeOnRequestContexts(Models\ServerDefinition $serverRequestDefinition)
    {
        foreach($serverRequestDefinition->getRequestDefinitions() as $requestDefinition) {
            $this->writeLine('function On'.$requestDefinition->getRequestType().$requestDefinition->getContext().'(array $parameter, Swoole\Http\Response $response) use ($api, $server) {', 1);
            foreach($requestDefinition->getParameterIds() as $parameterId) {
                $this->writeLine('$parameters[$parameterId]=$pathFragments[(array_search('.$parameterId.', $pathFragments) + 1)];', 1, 2);
            }

            $this->writeLine('$api->'.$requestDefinition->getOperationId().'(...$parameters)', 1, 2);

            $this->writeLine("});", 2);
        }
    }



    public function writeAdditionalLines(array $lines)
    {
        $this->lines = array_merge($this->lines, $lines);
    }



    private function writeLine(string $line, int $lineBreaksAfter, int $tabsBefore = 0)
    {
        $this->lines[] = str_repeat("\t", $tabsBefore);
        $this->lines[] = $line;
        $this->lines[] = str_repeat(PHP_EOL, $lineBreaksAfter);
    }

}