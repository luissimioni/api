<?php

namespace app\enum;

enum Events: string
{
    case DEPOSIT = 'deposit';
    case WITHDRAW = 'withdraw';
    case TRANSFER = 'transfer';
}