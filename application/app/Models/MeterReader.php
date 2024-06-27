<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeterReader extends Model
{
    use HasFactory;

    protected $fillable = [
        'meter_id',
        'reader_id'
    ];

    public function reader(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'reader_id', 'id');
    }
}
