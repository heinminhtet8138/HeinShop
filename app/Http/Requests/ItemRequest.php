<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class ItemRequest extends FormRequest
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
            'code_no' => 'required',
            'name' => 'required',
            'image' => 'required',File::types(['png']),
            'price' => 'required',
            'discount' => 'required',
            'in_stock' => 'required',
            'description' => 'required',
            'category_id' => 'required',

        ];
    }
}
