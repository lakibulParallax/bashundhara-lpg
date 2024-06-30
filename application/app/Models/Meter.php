<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meter extends Model
{
    use HasFactory;

    protected $fillable = [
        'meter_type',
        'number',
        'building',
        'flat_no',
        'customer_name',
        'address',
        'last_reading',
        'last_reading_date',
        'snd',
        'installation_date',
    ];

    protected $appends = ['meter_type_name'];

    public function getMeterTypeNameAttribute()
    {
        return $this->meter_type == '1' ? 'pre-paid' : 'post-paid';
    }

    public function getTotalDueAttribute()
    {
        $totalDue = 0;
        $currentDate = now();

        foreach ($this->bills as $bill) {
            if ($bill->payment_status == 0) {
                $finalPaymentDate = Carbon::parse($bill->final_payment_date);
                if ($currentDate->greaterThan($finalPaymentDate)) {
                    $totalDue += $bill->total_after_final_payment_date;
                } else {
                    $totalDue += $bill->amount;
                }
            }
        }

        return (string)$totalDue;
    }

    public function pendingBillsCount()
    {
        return $this->bills->where('payment_status', 0)->count();
    }

    public function users(): HasMany
    {
        return $this->hasMany(UserMeter::class, 'meter_id', 'id');
    }

    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class, 'meter_id', 'id');
    }

    public function meter_readers(): HasMany
    {
        return $this->hasMany(MeterReader::class, 'meter_id', 'id');
    }
}
