<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'name' => 'required|string|max:255',

            'category_id' => 'required|exists:categories,id',

            'description' => 'required|string',

            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',

            'stock' => 'required|integer|min:0',

            'price' => 'required|numeric|min:0',

            'sale_price' => 'nullable|numeric|min:0',

            'status' => 'required|in:active,inactive',

        ];
    }

    public function messages(): array
    {
        return [

            'name.required' => 'Tên sản phẩm không được để trống',

            'category_id.required' => 'Vui lòng chọn danh mục',

            'description.required' => 'Mô tả không được để trống',

            'image.image' => 'File phải là hình ảnh',

            'price.required' => 'Giá sản phẩm không được để trống',

            'stock.required' => 'Số lượng tồn kho không được để trống',

        ];
    }
}