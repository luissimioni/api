<?php

namespace app\controller;

use app\enum\HttpMethods;
use app\helper\Validator;

abstract class Controller
{
    protected ?array $args;
    protected ?array $requiredArgs;

    protected function setRequiredArgs(array $args) {
        $this->requiredArgs = $args;
    }

    protected function getArgs(HttpMethods $method): void
    {
        $this->args = match($method) {
            HttpMethods::GET => $_GET ?? null,
            HttpMethods::POST => $_POST ?? null,
        };
    }

    protected function validateArgs(): void
    {
        if (!Validator::validateArgs($this->requiredArgs, $this->args)) {
            http_response_code(400);

            exit;
        }
    }
}