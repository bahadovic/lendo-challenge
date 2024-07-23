<?php

namespace App\Enums;

enum OrderStatus: string
{
    case CheckHavingAccount = 'CHECK_HAVING_ACCOUNT';
    case OpeningBankAccount = 'OPENING_BANK_ACCOUNT';
}
