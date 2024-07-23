<?php

namespace Database\Factories;

use App\Enums\CustomerStatus;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition()
    {
        return [
            'bank_account_number' => $this->faker->optional()->bankAccountNumber,
            'status' => $this->faker->randomElement([CustomerStatus::Normal, CustomerStatus::Blocked]),
            'complete_info' => $this->faker->boolean,
            'mobile' => $this->faker->phoneNumber,
            'name' => $this->faker->name,
        ];
    }
}
