<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PpfBrand extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $guarded = [];

    public function ppfDetails()
    {
        return $this->hasMany(PpfDetails::class, 'ppf_id');
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photos')->singleFile();
    }
    public function getMediaUrlAttribute()
    {
        $media = $this->getFirstMedia('photos');
        return $media ? $media->getFullUrl() : null;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
