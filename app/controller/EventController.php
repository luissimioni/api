<?php

namespace app\controller;

use app\enum\Events;
use app\enum\HttpMethods;
use app\enum\HttpStatus;
use app\repository\AccountRepository;

class EventController extends Controller
{
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
}