<?php

namespace app\controller;

use app\enum\HttpStatus;

class ResetController extends Controller
{
    public function resetState(): void
    {
        if (apcu_clear_cache()) {
            $this->sendResponse(
                HttpStatus::OK
            );
        }
    }
}