<?php

namespace app\controller;

use app\enum\Events;
use app\enum\HttpMethods;
use app\enum\HttpStatus;
use app\repository\AccountRepository;

class AccountController extends Controller
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
    
    public function callEvent(): void
    {
        $this->setRequiredArgs([
            'type',
        ]);
        $this->getArgs(HttpMethods::POST);
        $this->validateArgs();

        $type = Events::tryFrom($this->args['type']);

        switch ($type) {
            case Events::DEPOSIT:
                $this->eventDeposit();

                break;

            case Events::WITHDRAW:
                $this->eventWithdraw();

                break;

            case Events::TRANSFER:
                $this->eventTransfer();

                break;
        }
    }

    private function eventDeposit(): void
    {
        $this->setRequiredArgs([
            'destination',
            'amount',
        ]);
        $this->validateArgs();

        $result['destination'] = AccountRepository::deposit(
                $this->args['destination'],
                $this->args['amount']
        );

        $this->sendResponse(
            HttpStatus::CREATED,
            $result
        );
    }

    private function eventWithdraw(): void
    {
        $this->setRequiredArgs([
            'origin',
            'amount',
        ]);
        $this->validateArgs();

        $result['origin'] = AccountRepository::withdraw(
                $this->args['origin'],
                $this->args['amount']
        );

        if (!$result['origin']) {
            $this->sendResponse(
                HttpStatus::NOT_FOUND,
                0
            );
            
            return;
        }

        $this->sendResponse(
            HttpStatus::CREATED,
            $result
        );
    }

    private function eventTransfer(): void
    {
        $this->setRequiredArgs([
            'origin',
            'amount',
            'destination',
        ]);
        $this->validateArgs();

        $result['origin'] = AccountRepository::withdraw(
                $this->args['origin'],
                $this->args['amount']
        );

        if (!$result['origin']) {
            $this->sendResponse(
                HttpStatus::NOT_FOUND,
                0
            );
            
            return;
        }

        $result['destination'] = AccountRepository::deposit(
            $this->args['destination'],
            $this->args['amount']
        );

        $this->sendResponse(
            HttpStatus::CREATED,
            $result
        );
    }
}