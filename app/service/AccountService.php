<?php

namespace app\service;

use app\repository\AccountRepository;

class AccountService
{
    private array $account;

    public function __construct(private ?array $args)
    {
    }

    public function getBalance(): bool|float
    {
        $account = AccountRepository::getAccountById($this->args['account_id']);

        if (!$account) {
            return false;
        }

        return $account['balance'];
    }

    public function eventDeposit(): array
    {
        $deposit['destination'] = AccountRepository::deposit(
                $this->args['destination'],
                $this->args['amount']
        );

        return $deposit;
    }

    public function eventWithdraw(): bool|array
    {
        $withdraw['origin'] = AccountRepository::withdraw(
                $this->args['origin'],
                $this->args['amount']
        );

        if (!$withdraw['origin']) {
            return false;
        }

        return $withdraw;
    }

    public function eventTransfer(): bool|array
    {
        $transfer['origin'] = AccountRepository::withdraw(
                $this->args['origin'],
                $this->args['amount']
        );

        if (!$transfer['origin']) {
            return false;
        }

        $transfer['destination'] = AccountRepository::deposit(
            $this->args['destination'],
            $this->args['amount']
        );

        return $transfer;
    }
}