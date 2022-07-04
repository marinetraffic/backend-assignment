<?php

namespace App\Models;

use App\Models\Traits\ShipPositionTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipPosition extends Model
{
    use HasFactory, ShipPositionTraits;

    protected $guarded = ['id'];

}
