<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\System\RoleHasPermission
 *
 * @property int $permission_id
 * @property int $role_id
 * @property-read \App\Models\System\Permission|null $permission
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermission query()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermission wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermission whereRoleId($value)
 * @mixin \Eloquent
 */
class RoleHasPermission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'permission_id',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

    ];

    public function permission()
    {
      return $this->belongsTo('App\Models\System\Permission', 'permission_id', 'id');
    }
}
