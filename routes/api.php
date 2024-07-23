<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;


Route::post('/order/register', [OrderController::class, 'register']);
