<?php

namespace app\route;

use app\helper\UrlHelper;

class Router
{
    private const ROUTES = [
        '/reset' => [
            'controller' => 'app\controller\ResetController',
            'methods' => [
                'POST' => 'reset',
            ],
        ],
        '/balance' => [
            'controller' => 'app\controller\BalanceController',
            'methods' => [
                'GET' => 'getBalance',
            ],
        ],
        '/event' => [
            'controller' => 'app\controller\EventController',
            'methods' => [
                'POST' => 'callEvent',
            ],
        ],
    ];

    private array $return;

    public static function route(string $requestUri)
    {
        $uri = UrlHelper::getUriWithoutArgs($requestUri);
        self::validateRoute($uri);
    }

    private static function validateRoute($uri): void
    {
        if (!isset(self::ROUTES[$uri]['methods'][$_SERVER['REQUEST_METHOD']])) {
            http_response_code(404);

            exit;
        }
    }
}