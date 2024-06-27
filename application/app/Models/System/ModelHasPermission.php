<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\System\ModelHasPermission
 *
 * @property int $permission_id
 * @property string $model_type
 * @property int $model_id
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission query()
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ModelHasPermission wherePermissionId($value)
 * @mixin \Eloquent
 */
class ModelHasPermission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'permission_id',
        'model_type',
        'model_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

    ];
}
