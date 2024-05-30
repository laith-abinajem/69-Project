<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class TintBrand extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    public function tintDetails()
    {
        return $this->hasMany(TintDetails::class, 'tint_id');
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photos')->singleFile();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
