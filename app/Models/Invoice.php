<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'user_id',
        'invoice_number',
        'invoice_date',
        'invoice_amount',
        'payment_status',
        'invoice_description',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
