<?php

namespace app\controller;

use app\enum\HttpMethods;
use app\enum\HttpStatus;
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
            $this->sendResponse(
                HttpStatus::BAD_REQUEST,
                null,
                true
            );
        }
    }

    protected function sendResponse(HttpStatus $status, array|string|int $output = null, bool $kill = false): void
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($status->value);

        $output = $output ?? $status->getStatusMessage();

        echo json_encode($output);

        if ($kill) {
            exit;
        }
    }
}