<?php

namespace app\controller;

use app\enum\Events;
use app\enum\HttpMethods;
use app\enum\HttpStatus;
use app\service\AccountService;

class AccountController extends Controller
{
    public function getBalance(): void
    {
        $this->setRequiredArgs([
            'account_id',
        ]);
        $this->getArgs(HttpMethods::GET);
        $this->validateArgs();

        $service = new AccountService($this->args);
        $response = $service->getBalance();

        if (!$response) {
            $this->sendResponse(
                HttpStatus::NOT_FOUND,
                0
            );

            return;
        }

        $this->sendResponse(
            HttpStatus::OK,
            $response
        );
    }

    public function callEvent(): void
    {
        $this->setRequiredArgs([
            'type',
        ]);
        $this->getArgs(HttpMethods::POST);
        $this->validateArgs();

        $service = new AccountService($this->args);
        $type = Events::tryFrom($this->args['type']);

        switch ($type) {
            case Events::DEPOSIT:
                $this->setRequiredArgs([
                    'destination',
                    'amount',
                ]);
                $this->validateArgs();

                $response = $service->eventDeposit();

                break;

            case Events::WITHDRAW:
                $this->setRequiredArgs([
                    'origin',
                    'amount',
                ]);
                $this->validateArgs();

                $response = $service->eventWithdraw();

                break;

            case Events::TRANSFER:
                $this->setRequiredArgs([
                    'origin',
                    'amount',
                    'destination',
                ]);
                $this->validateArgs();

                $response = $service->eventTransfer();

                break;
        }

        if (!$response) {
            $this->sendResponse(
                HttpStatus::NOT_FOUND,
                0
            );

            return;
        }

        $this->sendResponse(
            HttpStatus::CREATED,
            $response
        );
    }
}