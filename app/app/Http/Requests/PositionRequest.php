<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class PositionRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'mmsi' => ['integer'],
            'maxLat' => ['numeric', 'gt:minLat'],
            'minLat' => ['numeric', 'lt:maxLat'],
            'maxLon' => ['numeric', 'gt:minLon'],
            'minLon' => ['numeric', 'lt:maxLon'],
            'fromDatetime' => ['date', 'before:toDatetime'],
            'toDatetime' => ['date', 'after:fromDatetime'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
