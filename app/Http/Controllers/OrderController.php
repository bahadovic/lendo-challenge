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
        try {
            $order = $this->service->register($request->validated()->toAraay());
            return $this->responseFormatter->success($order, 'Order registered successfully');
        } catch (ValidationException $e) {
            return $this->responseFormatter->error('Validation failed', 422, $e->errors());
        } catch (\Exception $e) {
            return $this->responseFormatter->error($e->getMessage(), 400);
        }
    }
}
