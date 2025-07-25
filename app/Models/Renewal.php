<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Renewal extends Model
{
    protected $table = 'renewals';

    protected $fillable = [
        'user_id',
        'application_no',
        'application_date',
        'dl_number',
        'dl_covs',
        'nt_validity',
        'tr_validity',
        'learning_no',
        'mobile_no',
        'license_approval_date',
        'licence_type',
        'rto_office',
        'result',
        'status', // Assuming you want to track the status of the renewal
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
