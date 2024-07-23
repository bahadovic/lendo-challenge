<?php
namespace App\Services\SmsDrivers;

use App\Interfaces\SmsDriverInterface;
use InvalidArgumentException;

class SmsDriverFactory
{
    protected array $drivers = [
        'driverA' => SmsDriverA::class,
        'driverB' => SmsDriverB::class,
        'driverC' => SmsDriverC::class,
        'loadBalancer' => SmsLoadBalancer::class,
    ];

    public function create(string $driver): SmsDriverInterface
    {
        if (!isset($this->drivers[$driver])) {
            throw new InvalidArgumentException("Driver [{$driver}] not supported.");
        }

        return new $this->drivers[$driver]();
    }
}
