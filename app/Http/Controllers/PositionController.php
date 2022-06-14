<?php

namespace App\Http\Controllers;

use App\Http\Filters\Conditions\LatLongFilter;
use App\Http\Filters\Conditions\MmsiFilter;
use App\Http\Filters\Conditions\TimeFilter;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\Pure;

class PositionController extends Controller
{
    public function index(){
         return Position::withFilter($this->filter())->latest()->paginate(100)->withQueryString();;
    }

    /*
     * Filter Parameters
     *
     * Based On The request() Param, Call The Respective Class
     */
   protected function filter(): array
    {
        return [
            'latlong' => new LatLongFilter(),
            'mmsi' => new MmsiFilter(),
            'time' => new TimeFilter()
        ];
    }
}
