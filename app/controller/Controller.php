<?php

namespace app\controller;

use app\enum\HttpMethods;

abstract class Controller
{
    protected ?array $args;

    protected function getArgs(HttpMethods $method): bool
    {
        $this->args = match($method) {
            HttpMethods::GET => $_GET ?? null,
            HttpMethods::POST => $_POST ?? null,
        };

        return (bool) $this->args;
    }
}