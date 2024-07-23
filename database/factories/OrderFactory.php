<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'customer_id' => Customer::factory(),
            'amount' => $this->faker->randomElement([10000000, 12000000, 15000000, 20000000]),
            'invoice_count' => $this->faker->randomElement([6, 9, 12]),
            'status' => $this->faker->randomElement([OrderStatus::CheckHavingAccount, OrderStatus::OpeningBankAccount]),
        ];
    }
}
