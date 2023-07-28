<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DrivrLoginRequest extends FormRequest
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
            'phone'=>'required|exists:drivers,phone',
            'password'=>'required',
            'country_key'=>'required|max:3|exists:drivers,country_key'
        ];
    }
}
