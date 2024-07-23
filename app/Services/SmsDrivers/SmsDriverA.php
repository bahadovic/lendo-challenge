<?php
namespace App\Services\SmsDrivers;

use App\Interfaces\SmsDriverInterface;
use Illuminate\Support\Facades\Http;

class SmsDriverA implements SmsDriverInterface
{
    public string $baseUrl;
    public string $username;
    public string $password;


    public function __construct()
    {
        $this->baseUrl = config('sms.SmsA.endpoint');
        $this->username = config('sms.SmsA.username');
        $this->password = config('sms.SmsA.password');

    }
    public function sendSms(string $receptor, string $message): bool
    {
        $response = Http::post($this->baseUrl, [
            'username' => $this->username,
            'password' => $this->password,
            'receptor' => $receptor,
            'message' => $message,
        ]);

        return $response->successful();
    }
}
