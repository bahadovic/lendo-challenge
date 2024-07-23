<?php

namespace Tests\Unit;

use App\Enums\CustomerStatus;
use App\Models\Customer;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\smsDrivers\SmsDriverFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $smsDriverFactory;
    protected $orderService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->smsDriverFactory = $this->createMock(SmsDriverFactory::class);
        $this->orderService = new OrderService($this->smsDriverFactory);
    }

    public function testRegisterOrderSuccess()
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

        $result = $this->orderService->register($data);

        $this->assertTrue($result['success']);
        $this->assertEquals('Order registered successfully', $result['message']);
        $this->assertInstanceOf(Order::class, $result['data']);
        $this->assertDatabaseHas('orders', ['customer_id' => $customer->id, 'amount' => 10000000]);
    }

    public function testRegisterOrderFailure()
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

        $result = $this->orderService->register($data);

        $this->assertFalse($result['success']);
        $this->assertEquals('Customer is not eligible to place an order.', $result['message']);
        $this->assertNull($result['data']);
    }
}
