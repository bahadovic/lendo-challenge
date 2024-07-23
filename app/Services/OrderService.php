<?php
namespace App\Services;

use App\Enums\CustomerStatus;
use App\Enums\OrderStatus;
use App\Interfaces\SmsDriverInterface;
use App\Models\Customer;
use App\Models\Order;
use App\Services\SmsDrivers\SmsDriverFactory;


class OrderService
{
    protected SmsDriverInterface $smsDriver;

    public function __construct(SmsDriverFactory $smsFactory)
    {
        $driver = config('sms.sms_driver', 'loadBalancer');
        $this->smsDriver = $smsFactory->create($driver);
    }

    public function register($params)
    {
        $customer = Customer::find($params['customer_id']);

        if ($customer->status == CustomerStatus::Blocked || !$customer->complete_info) {
            return [
                'success' => false,
                'message' => 'Customer is not eligible to place an order.',
                'httpStatusCode' => '400'
            ];
        }

        $orderStatus = $customer->bank_account_number ? OrderStatus::CheckHavingAccount : OrderStatus::OpeningBankAccount;

        $order = Order::create([
            'customer_id' => $params['customer_id'],
            'amount' => $params['amount'],
            'invoice_count' => $params['invoice_count'],
            'status' => $orderStatus,
        ]);

        $message = "Dear {$customer->name},\nYour order has been registered successfully.\nThank you.";

        $this->smsDriver->sendSms($customer->mobile, $message);

        return [
            'success' => true,
            'message' => 'Order registered successfully',
            'data' => $order,
            'httpStatusCode' => '200'
        ];
    }
}
