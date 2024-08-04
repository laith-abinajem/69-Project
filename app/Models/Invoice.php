<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetails::class, 'invoice_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {
            $lastInvoice = Invoice::latest()->first();
            $number = $lastInvoice ? intval(substr($lastInvoice->invoice_no, 2)) + 1 : 1;
            $invoice->invoice_no = 'INV-' . str_pad($number, 8, '0', STR_PAD_LEFT);
        });
    }
}
