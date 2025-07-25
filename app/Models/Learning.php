<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Learning extends Model
{
    protected $table = 'learnings';

    protected $fillable = [
        'user_id',
        'application_no',
        'application_date',
        'dl_covs',
        'learning_no',
        'mobile_no',
        'learning_created_date',
        'learning_expired_date',
        'licence_type',
        'appointment_date',
        'rto_office',
        'attendance',
        'result',
        'status', // Assuming you want to track the status of the learning
    ];
    protected $casts = [
        'json' => 'array', // Cast the JSON field to an array
    ];
    protected $hidden = [
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
