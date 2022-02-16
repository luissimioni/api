<?php

namespace app\controller;

use app\enum\HttpMethods;
use app\enum\HttpStatus;
use app\repository\AccountRepository;

class BalanceController extends Controller
{
    public function getBalance(): void
    {
        $this->setRequiredArgs([
            'account_id',
        ]);
        $this->getArgs(HttpMethods::GET);
        $this->validateArgs();

        $balance = AccountRepository::getBalanceById($this->args['account_id']);

        if (!$balance) {
            $this->sendResponse(
                HttpStatus::NOT_FOUND,
                0
            );

            return;
        }

        $this->sendResponse(
            HttpStatus::OK,
            $balance['balance']
        );
    }
}