<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
        $imageRules = [
            'required', 
            'image',     
            'mimes:jpeg,png,jpg',
            'max:2048',
        ];
        $nameRules=[
            "required",
            "string"
        ];
        return [
            'email' => ['nullable', 'email', 'unique:users,email'], 
            "password"=>["required"],
            "phone"=>["required","digits:10","numeric","unique:users,phone"],
            "first_name"=>$nameRules,
            "last_name"=>$nameRules,
            "date_of_birth"=>["required"],
           "personal_photo"=>$imageRules,
            "ID_photo"=>$imageRules,
            // "role"=>["required"]
          
        ];
    }
}
