<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'status',
    ];

    protected $casts = [
        'json' => 'array', // Cast the JSON field to an array
    ];
    protected $hidden = [
        'created_by',
        'updated_by',
        'deleted_at',
    ];

}
