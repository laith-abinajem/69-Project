<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class Detailing extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('detailing_image')->singleFile();
    }
    public function detailingDetails()
    {
        return $this->hasMany(DetailingDetails::class, 'detailing_id');
    }
    public function getMediaUrlAttribute()
    {
        $media = $this->getFirstMedia('detailing_image');
        return $media ? $media->getFullUrl() : null;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}