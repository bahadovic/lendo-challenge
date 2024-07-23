<?php
namespace App\Services;

use App\Models\Customer;
use App\Models\Order;
use App\Services\SmsDrivers\SmsLoadBalancer;

class OrderService
{
    protected SmsLoadBalancer $smsLoadBalancer;

    public function __construct(SmsLoadBalancer $smsLoadBalancer)
    {
        $this->smsLoadBalancer = $smsLoadBalancer;
    }

    public function register($params)
    {
        $customer = Customer::find($params['customer_id']);

        if ($customer->status == 'blocked' || !$customer->complete_info) {
            return ['data' => ['message' => 'Customer is not eligible to place an order.'], 'httpStatusCode' => 400];
        }

        $orderStatus = $customer->bank_account_number ? 'CHECK_HAVING_ACCOUNT' : 'OPENING_BANK_ACCOUNT';

        Order::create([
            'customer_id' => $params['customer_id'],
            'amount' => $params['amount'],
            'invoice_count' => $params['invoice_count'],
            'status' => $orderStatus,
        ]);

        $message = "Dear {$customer->name},\nYour order has been registered successfully.\nThank you.";

        $this->smsLoadBalancer->sendSms($customer->mobile, $message);

        return ['data' => ['message' => 'Order registered successfully.'],'httpStatusCode' => 200];
    }
}
