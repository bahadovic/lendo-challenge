<?php
namespace App\Services\SmsDrivers;

use App\Interfaces\SmsDriverInterface;
use Illuminate\Support\Facades\Log;

class SmsLoadBalancer
{
    protected array $drivers = [];
    protected int $currentDriverIndex = 0;

    public function __construct()
    {
        $this->drivers = [
            new SmsDriverA(),
            new SmsDriverB(),
            new SmsDriverC(),
        ];
    }

    public function sendSms(string $receptor, string $message): bool
    {
        $driver = $this->getNextDriver();
        try {
            return $driver->sendSms($receptor, $message);
        } catch (\Exception $e) {
            Log::error("Failed to send SMS using " . get_class($driver) . ": " . $e->getMessage());
            return $this->sendSms($receptor, $message);
        }
    }

    protected function getNextDriver(): SmsDriverInterface
    {
        $driver = $this->drivers[$this->currentDriverIndex];
        $this->currentDriverIndex = ($this->currentDriverIndex + 1) % count($this->drivers);
        return $driver;
    }
}
