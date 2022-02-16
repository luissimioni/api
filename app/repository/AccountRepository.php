<?php

namespace app\repository;

class AccountRepository
{
    public static function getBalanceById(string $id): array
    {
        return apcu_fetch($id) ?: [];
    }

    public static function deposit(string $id, int $amount): array
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
    }
}