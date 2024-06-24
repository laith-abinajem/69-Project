<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class AddsOn extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $guarded = [];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('addon_image')->singleFile();
    }
    public function getMediaUrlAttribute()
    {
        $media = $this->getFirstMedia('addon_image');
        return $media ? $media->getFullUrl() : null;
    }
}
