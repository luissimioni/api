<?php

namespace app\helper;

class UrlHelper
{
    public static function getUriWithoutArgs(string $uri): string
    {
        return parse_url($uri, PHP_URL_PATH);
    }
}