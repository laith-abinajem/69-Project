<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TintDetails extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function tintBrand()
    {
        return $this->belongsTo(TintBrand::class, 'tint_id');
    }
}
