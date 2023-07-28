<?php

namespace App\Http\Requests\Driver;

use Illuminate\Foundation\Http\FormRequest;

class DriverUpdateinfoRequest extends FormRequest
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
            'driver_name'=> 'required',
            'image'=> 'mimes:jpeg,jpg,png,gif|max:1000|unique:users,image',
            'phone'=> 'required|unique:drivers,phone',
            'city'=> 'required',
            'address'=>'required',
            'email'=>'required|email|unique:drivers,email',
        ];
    }
}
