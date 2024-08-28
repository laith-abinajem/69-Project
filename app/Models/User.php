<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\HasMedia;

use Spatie\MediaLibrary\InteractsWithMedia;
class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'type',
        'sub_id',
        'code',
        'square_customer_id',
        'card_id',
        'session_id',
        'parent_id',
        'language',
        'currency',
        'custom_text',
        'hex',
        'api_key',
        'business_id',
        'company_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function tintBrands()
    {
        return $this->hasMany(TintBrand::class);
    }
    
    public function ppfBrands()
    {
        return $this->hasMany(PpfBrand::class);
    }
    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }
    public function detailingBrands()
    {
        return $this->hasMany(Detailing::class);
    }
    public function lightTints()
    {
        return $this->hasMany(LightTint::class);
    }
    public function subscription()
    {
        return $this->hasMany(Subscription::class);
    }
    public function card()
    {
        return $this->belongsTo(Card::class, 'card_id');
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('company_logo')
            ->singleFile(); 
        $this->addMediaCollection('decal_logo')
            ->singleFile(); 
        $this->addMediaCollection('detailing_decal')
        ->singleFile(); 

            $this->addMediaCollection('videos')
            ->acceptsMimeTypes(['video/mp4', 'video/avi', 'video/mpeg', 'video/quicktime'])
            ->useDisk('videos'); // Ensure 'videos' disk is defined in config/filesystems.php
    }
}
