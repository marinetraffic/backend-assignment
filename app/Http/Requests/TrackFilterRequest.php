<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrackFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'mmsi' => 'array',
            'mmsi.*' => 'numeric',
            'lat_range' => 'array|min:2|max:2',
            'lat_range.*' => 'numeric',
            'lon_range' => 'array|min:2|max:2',
            'lon_range.*' => 'numeric',
            'interval_range' => 'array|min:2|max:2',
            'interval_range.*' => 'numeric'
        ];
    }
}
