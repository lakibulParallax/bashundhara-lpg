<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserMeter extends Model
{
    use HasFactory;

    public function meter(): BelongsTo
    {
        return $this->belongsTo(Meter::class, 'meter_id', 'id');
    }
}
