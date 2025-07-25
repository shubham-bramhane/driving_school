<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driving extends Model
{
    protected $table = 'drivings';

    protected $fillable = [
        'user_id',
        'application_no',
        'application_date',
        'dl_number',
        'dl_covs',
        'nt_validity',
        'tr_validity',
        'mobile_no',
        'license_approved_date',
        'licence_type',
        'appointment_date',
        'rto_office',
        'attendance',
        'result'
    ];

    protected $casts = [
        'json' => 'array', // Cast the JSON field to an array
    ];

    protected $hidden = [
        'created_by',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
