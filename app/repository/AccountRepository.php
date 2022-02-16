<?php

namespace app\repository;

class AccountRepository
{
    public static function getBalanceById(string $id): array
    {
        return apcu_fetch($id) ?: [];
    }
}