<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bill extends Model
{
    use HasFactory;

    protected $appends = ['payment_status_name'];

    public function getPaymentStatusNameAttribute()
    {
        return $this->payment_status == '0' ? 'un-paid' : 'paid';
    }

    public function payment_transaction(): HasOne
    {
        return $this->hasOne(PaymentTransaction::class, 'id', 'payment_transaction_id');
    }
}
