<?php

namespace app\route;

use app\helper\UrlHelper;

class Router
{
    private const ROUTES = [
        '/reset' => [
            'controller' => 'app\controller\ResetController',
            'methods' => [
                'POST' => 'resetState',
            ],
        ],
        '/balance' => [
            'controller' => 'app\controller\AccountController',
            'methods' => [
                'GET' => 'getBalance',
            ],
        ],
        '/event' => [
            'controller' => 'app\controller\AccountController',
            'methods' => [
                'POST' => 'callEvent',
            ],
        ],
    ];

    public static function route(string $requestUri): void
    {
        $uri = UrlHelper::getUriWithoutArgs($requestUri);
        self::validateRoute($uri);

        $controllerClass = self::ROUTES[$uri]['controller']; 
        $controller = new $controllerClass();

        $methodName = self::ROUTES[$uri]['methods'][$_SERVER['REQUEST_METHOD']];
        $controller->$methodName();
    }

    private static function validateRoute($uri): void
    {
        if (!isset(self::ROUTES[$uri]['methods'][$_SERVER['REQUEST_METHOD']])) {
            http_response_code(404);

            exit;
        }
    }
}
