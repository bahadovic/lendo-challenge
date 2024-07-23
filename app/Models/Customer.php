<?php

namespace App\Models;

use App\Enums\CustomerStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Customer extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'bank_account_number', 'status', 'complete_info', 'mobile', 'name'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => CustomerStatus::from($value),
            set: fn (CustomerStatus $status) => $status->value,
        );
    }
}
