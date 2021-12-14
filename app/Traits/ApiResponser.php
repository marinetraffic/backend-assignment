<?php

/**
 * PHP implements a way to reuse code called Traits. 
 * Traits are a mechanism for code reuse in single inheritance languages such as PHP
 * A Trait is intended to reduce some limitations of single inheritance 
 * by enabling a developer to reuse 
 * sets of methods freely 
 * in several independent classes living in different class hierarchies
 * 
 * A Trait is similar to a class, 
 * but only intended to group functionality in a fine-grained and consistent way
 * 
 * It is not possible to instantiate a Trait on its own
 * 
 * It is an addition to traditional inheritance and enables horizontal composition of behavior, 
 * that is, 
 * the application of class members without requiring inheritance
 */

namespace App\Traits;

/**
 * The Illuminate\Support\Collection class provides a fluent, 
 * convenient wrapper for working with arrays of data
 * 
 * https://laravel.com/docs/8.x/collections 
 */

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ApiResponser
{
    /**
     * Receives the data to be returned
     * and the code of that response
     */
    private function successResponse($data, $code)
    {
        // Log::info(response()->json($data, $code));
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code)
    {
        // Log::error(response()->json(['error' => $message, 'code' => $code], $code));
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function showAll(Collection $collection, $code = 200)
    {
        // Log::info(response()->json(['data_collection' => $collection], $code));
        return response()->json(['data_collection' => $collection], $code);
    }

    protected function showOne(Model $model, $code)
    {
        // Log::info(response()->json(['data_collection' => $model], $code));
        return response()->json(['data_model' => $model], $code);
    }
}
