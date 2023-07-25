<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_name'=> 'required',
            'image'=> 'mimes:jpeg,jpg,png,gif|max:1000|unique:users,image',
            'phone'=> 'required|unique:users,phone',
            'city'=> 'required',
            'password'=> 'required|min:8|confirmed',
            'country_key'=>'required|max:3'
        ];
    }
}
