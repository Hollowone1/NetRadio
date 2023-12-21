<?php

namespace radio\net\app\action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class GenerateAction
{
    abstract function generateActionResponse (ServerRequestInterface $request, ResponseInterface $response, $service);
}