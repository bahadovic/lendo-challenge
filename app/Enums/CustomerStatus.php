<?php

namespace App\Enums;

enum CustomerStatus: string
{
    case Normal = 'normal';
    case Blocked = 'blocked';
}
