<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingRequest extends Model
{
    use HasFactory;

    protected $table = "incoming_requests";

    protected $guarded = [];
}
