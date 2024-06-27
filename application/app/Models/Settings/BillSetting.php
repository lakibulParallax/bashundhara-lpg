<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillSetting extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'type', 'value', 'status'];
}
