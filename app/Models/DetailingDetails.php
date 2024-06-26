<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailingDetails extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function detailingBrand()
    {
        return $this->belongsTo(Detailing::class, 'detailing_id');
    }
}
