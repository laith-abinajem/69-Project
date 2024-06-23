<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class LightTint extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    public function lightDetails()
    {
        return $this->hasMany(LightTintDetails::class, 'light_id');
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('light_image')->singleFile();
    }
    public function getMediaUrlAttribute()
    {
        $media = $this->getFirstMedia('light_image');
        return $media ? $media->getFullUrl() : null;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
