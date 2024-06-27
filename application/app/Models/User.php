<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use HasRoles;
    use HasFactory, Notifiable, HasApiTokens, InteractsWithMedia;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
        'nid',
        'age',
        'passport',
        'father_name',
        'mother_name',
        'is_active',
        'is_phone_verified',
        'is_email_verified',
        'plot_no',
        'block_id',
        'road_id',
        'building_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = [
        'password',
        'phone_verified_at',
        'created_at',
        'updated_at',
        'temporary_token',
        'otp',
        'otp_expires_at',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function fileManager(): MorphMany
    {
        return $this->morphMany(FileManager::class, 'origin');
    }

    public function getImagesAttribute()
    {
        $images = array();
        if ($this->fileManager) {
            foreach ($this->fileManager as $file) {
                $obj = new \stdClass();
                $obj->id = $file->id;
                $obj->url = $file->url;
                $images[] = $obj;
            }
            return $images;
        }
        return asset('application/public/storage/no_image.jpg');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')->singleFile();
    }
    public function getAvatarAttribute(): ?string
    {
        if ($this->hasMedia('avatar')) {
            return $this->getFirstMediaUrl('avatar');
        }
        return asset('blank.png');
    }

    public function user_meters(): HasMany
    {
        return $this->hasMany(UserMeter::class, 'user_id', 'id');
    }
}
