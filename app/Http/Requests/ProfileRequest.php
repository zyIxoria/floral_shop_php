<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [

            'name' => 'required|string|max:255',

            'email' =>
                'required|email|unique:users,email,' . auth()->id(),

            'phone' => 'nullable|string|max:20',

            'address' => 'nullable|string|max:1000',

        ];
    }

    public function messages(): array
    {
        return [

            'name.required' =>
                'Tên không được để trống',

            'email.required' =>
                'Email không được để trống',

            'email.email' =>
                'Email không hợp lệ',

            'email.unique' =>
                'Email đã tồn tại',

        ];
    }
}