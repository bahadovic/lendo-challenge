<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\SmsDrivers\SmsLoadBalancer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderService $service
    )
    {
    }
    public function register(OrderRequest $request)
    {
        $data = $this->service->register(params: $request->safe()->toArray());
        return response()->json(data: $data['data'], status: $data['httpStatusCode']);
    }
}
