<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;

/**
 * We need to use the Trait ApiResponser in ApiController
 * doing that we can use the trait directly in all other controllers
 * since they are extended
 */
class ApiController extends Controller
{
    use ApiResponser; //we can use every trait method directly in our Controllers
}
