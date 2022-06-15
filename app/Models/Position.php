<?php

namespace App\Models;

use App\Traits\CanBeFiltered;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory, CanBeFiltered;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'boolean',
//        'timestamp' => 'datetime',
    ];
}
