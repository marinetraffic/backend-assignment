<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrackCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'mmsi' => 'required|numeric',
            'status' => 'required|numeric',
            'stationId' => 'required|numeric',
            'speed' => 'required|numeric',
            'lon' => 'required|numeric|between:-180,180',
            'lat' => 'required|numeric|between:-90,90',
            'course' => 'required|numeric',
            'heading' => 'required|numeric',
            'timestamp' => 'required|numeric',
        ];
    }
}
