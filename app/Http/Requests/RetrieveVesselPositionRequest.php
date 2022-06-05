<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RetrieveVesselPositionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'mmsi' => 'string|regex:/^[0-9]+(,[0-9]+)*$/',
            'coordinates' => 'regex:/^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?),\s*[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$/',
            'timestamps' => 'string',
            'per_page' => 'int|min:1'
        ];
    }

    /**
     * Override the `failedValidation` method and make it return a json response, because by default Laravel returns a 403 when api validation fails
     *
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator): void
    {
        $response = response()->json([
            'message' => 'Invalid data',
            'details' => $validator->errors()->messages(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
