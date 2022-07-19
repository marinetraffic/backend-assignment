<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VesselPosition extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = ['id'];
    protected $table = "vessel_positions";
}
