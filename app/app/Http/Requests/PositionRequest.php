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
        $request = request();
//        dd(request()->all());
        return [
            'mmsi' => ['integer'],
            'maxLat' => ['numeric', function ($attribute, $value, $fail) use ($request) {
                if($request->has('minLat')){
                    $value >= $request->get('minLat');

                    $fail('The '. $attribute .' must be greater than minLat.');
                }
            }],
            'minLat' => ['numeric', function ($attribute, $value, $fail) use ($request) {
                if($request->has('maxLat')){
                    $value <= $request->get('maxLat');

                    $fail('The '. $attribute .' must be lesser than maxLat.');
                }
            }],
            'maxLon' => ['numeric', function ($attribute, $value, $fail) use ($request) {
                if($request->has('minLon')){
                    $value >= $request->get('minLon');

                    $fail('The '. $attribute .' must be greater than minLon.');
                }
            }],
            'minLon' => ['numeric', function ($attribute, $value, $fail) use ($request) {
                if($request->has('maxLon')){
                    $value <= $request->get('maxLon');

                    $fail('The '. $attribute .' must be lesser than maxLon.');
                }
            }],
            'fromDatetime' => ['date', function ($attribute, $value, $fail) use ($request) {
                if($request->has('toDatetime')){
                    $value <= $request->get('toDatetime');

                    $fail('The '. $attribute .' must be previous to toDatetime.');
                }
            }],
            'toDatetime' => ['date', 'after:fromDatetime', function ($attribute, $value, $fail) use ($request) {
                if($request->has('fromDatetime')){
                    $value >= $request->get('fromDatetime');

                    $fail('The '. $attribute .' must be later then fromDatetime.');
                }
            }],
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
