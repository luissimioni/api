<?php

namespace app\enum;

enum HttpStatus: int
{
    case OK = 200;
    case CREATED = 201;
    case BAD_REQUEST = 400;
    case NOT_FOUND = 404;

    public function getStatusMessage(): string
    {
        return match($this) {
            self::OK => 'OK',
            self::CREATED => 'Created.',
            self::BAD_REQUEST => 'Bad request. Invalid params.',
            self::NOT_FOUND => 'Not found.',
        };
    }
}