<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;

class VesselPosition extends Model
{
    use SpatialTrait;
    public $timestamps = false;

    /**
     * The attributes that are mass-assignable.
     *
     * @var array
     */

    /**
     * The attributes that are spatial fields.
     *
     * @var array
     */
    protected $spatialFields = [
        'position'
    ];


}
