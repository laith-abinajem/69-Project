<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpfDetails extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    
    public function ppfBrand()
    {
        return $this->belongsTo(PpfBrand::class, 'ppf_id');
    }
}
