<?php

namespace Tests\Feature;

use App\Enums\CustomerStatus;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class OrderRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function testOrderRegistrationSuccess()
    {
        Http::fake([
            'https://mockapi.smsdrivera.com/send' => Http::response(['status' => 'success'], 200),
        ]);

        $customer = Customer::factory()->create([
            'bank_account_number' => '123456789',
            'status' => CustomerStatus::Normal,
            'complete_info' => true,
        ]);

        $data = [
            'customer_id' => $customer->id,
            'amount' => 10000000,
            'invoice_count' => 6,
        ];

        $response = $this->postJson('/order/register', $data);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Order registered successfully',
            ]);

        $this->assertDatabaseHas('orders', ['customer_id' => $customer->id, 'amount' => 10000000]);
    }

    public function testOrderRegistrationValidationFailure()
    {

        $response = $this->postJson('/order/register', [
            'customer_id' => null,
            'amount' => 999,
            'invoice_count' => 5,
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'Validation failed',
            ]);
    }

    public function testOrderRegistrationCustomerBlocked()
    {
        $customer = Customer::factory()->create([
            'status' => CustomerStatus::Blocked,
            'complete_info' => true,
        ]);

        $data = [
            'customer_id' => $customer->id,
            'amount' => 10000000,
            'invoice_count' => 6,
        ];

        $response = $this->postJson('/order/register', $data);

        $response->assertStatus(400)
            ->assertJson([
                'status' => 'error',
                'message' => 'Customer is not eligible to place an order.',
            ]);
    }
}
