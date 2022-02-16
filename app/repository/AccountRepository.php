<?php

namespace app\repository;

class AccountRepository
{
    public static function getBalanceById(string $id): array
    {
        return apcu_fetch($id) ?: [];
    }

    public static function deposit(string $id, float $amount): array
    {
        $account = apcu_fetch($id);

        if (!$account) {
            $account = [
                'id' => $id,
                'balance' => $amount,
            ];

            apcu_store($id, $account);

            return $account;
        }

        $account['balance'] += $amount;
        apcu_store($id, $account);

        return $account;
    }

    public static function withdraw(string $id, float $amount): array|bool
    {
        $account = apcu_fetch($id);

        if (!$account) {
            return false;
        }

        $account['balance'] -= $amount;
        apcu_store($id, $account);

        return $account;
    }
}