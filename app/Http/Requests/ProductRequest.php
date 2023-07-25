<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'product_name'=>'required|string',
            'price_kilo'=>'required',
            'discreption'=>'required|string',
            'image'=>'mimes:jpeg,jpg,png,gif|max:1000|unique:products,image',
            'discount'=>'string',
            'product_code'=>'required',
            'stock'=>'required',
            // 'category_id'=>'required'
        ];
    }
}
