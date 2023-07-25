<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateinfoRequest extends FormRequest
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
            'image'=> 'mimes:jpeg,jpg,png,gif|max:2000|unique:users,phone',
            // 'phone'=> 'required|unique:users,phone',
            'city'=> 'required',
            // 'password'=> 'required|min:8|confirmed'
        ];
    }
}
