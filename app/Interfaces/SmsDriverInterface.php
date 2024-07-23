<?php

namespace App\Interfaces;

interface SmsDriverInterface
{
    public function sendSms(string $receptor, string $message): bool;
}
