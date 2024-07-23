<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Order extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'customer_id', 'amount', 'invoice_count', 'status'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => OrderStatus::from($value),
            set: fn (OrderStatus $status) => $status->value,
        );
    }
}
