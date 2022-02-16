<?php

class Autoloader
{
    public static function load(): void
    {
        spl_autoload_register(function ($className) {
            $filePath = str_replace('\\', DIRECTORY_SEPARATOR, $className).'.php';

            if (file_exists($filePath)) {
                require $filePath;

                return true;
            }

            return false;
        });
    }
}