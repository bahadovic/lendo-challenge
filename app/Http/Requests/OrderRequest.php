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

    public function messages()
    {
        return [
            'customer_id.required' => 'The customer ID is required.',
            'customer_id.exists' => 'The selected customer ID is invalid.',
            'amount.required' => 'The amount is required.',
            'amount.in' => 'The selected amount is invalid.',
            'invoice_count.required' => 'The invoice count is required.',
            'invoice_count.in' => 'The selected invoice count is invalid.',
        ];
    }

    public function authorize()
    {
        return true;
    }

}
