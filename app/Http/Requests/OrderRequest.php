<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function rules()
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|in:10000000,12000000,15000000,20000000',
            'invoice_count' => 'required|in:6,9,12',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
