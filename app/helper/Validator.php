<?php

namespace app\helper;

class Validator
{
    public static function validateArgs(?array $required, ?array $args): bool
    {
        if (!$required) {
            return true;
        }

        if (!$args) {
            return false;
        }

        $argsIndex = array_keys($args);

        return !(bool) array_diff($required, $argsIndex);
    }
}