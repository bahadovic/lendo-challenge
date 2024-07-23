<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Services\OrderService;
use App\Services\ResponseFormatter;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderService $service,private readonly ResponseFormatter $responseFormatter
    )
    {
    }
    public function register(OrderRequest $request)
    {
        $result = $this->service->register($request->validated()->toArray());

        if (!$result['success']) {
            return $this->responseFormatter->error($result['message'], $result['httpStatusCode'], $result['errors'] ?? null);
        }

        return $this->responseFormatter->success($result['data'], $result['message'], $result['httpStatusCode']);
    }
}
