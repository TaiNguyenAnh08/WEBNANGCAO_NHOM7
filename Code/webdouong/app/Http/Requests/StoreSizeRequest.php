<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSizeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; //ai cũng requets được 
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:sizes,name|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên kích thước là bắt buộc',
            'name.unique' => 'Kích thước này đã tồn tại',
        ];
    }
}
