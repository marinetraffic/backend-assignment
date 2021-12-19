<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Details extends Model {

    /**
     * The database table used by the model
     * 
     * @var array
     */
    protected $table = 'vs_details';

    /**
     * The attributes that are mass assignable.
     *
     *  @var array
     */
    protected $fillable = ['mmsi', 'status', 'station', 'speed', 'lon', 'lat', 'course', 'heading', 'rot', 'timestamp'];

}

?>