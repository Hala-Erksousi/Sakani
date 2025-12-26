<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'apartment_id'=>['required','exists:apartments,id'],
            'booking_id' => ['required','exists:bookings,id','unique:reviews,booking_id'],

            'stars' => ['required','integer','min:1','max:5'],


            'comment'    => ['nullable','string','max:1000'],
        ];
    }
}
