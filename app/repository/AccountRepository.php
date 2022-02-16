<?php

namespace app\repository;

class AccountRepository
{
    public static function getAccountById(string $id): array
    {
        return apcu_fetch($id) ?: [];
    }

    public static function deposit(string $id, float $amount): array
    {
        $account = self::getAccountById($id);

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
        $account = self::getAccountById($id);

        if (!$account) {
            return false;
        }

        $account['balance'] -= $amount;
        apcu_store($id, $account);

        return $account;
    }
}