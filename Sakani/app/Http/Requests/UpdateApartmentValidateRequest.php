<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApartmentValidateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'price'       => ['sometimes'],
            'rooms'       => ['sometimes', 'integer', 'min:1'],
            'bathrooms'   => ['sometimes', 'integer', 'min:1'],
            'space'       => ['sometimes', 'numeric'],
            'floor'       => 'sometimes|integer',
            'title_deed'  => 'sometimes|string',
            'governorate' => 'sometimes|string|max:100',
            'city'        => 'sometimes|string|max:100',
        ];
    }
}
