<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [

            'shipping_email' => 'required|email',

            'shipping_phone' => 'required|string|max:20',

            'shipping_address' => 'required|string|max:1000',

            'payment_method' => 'required|in:cod,vnpay',

            'coupon_id' => 'nullable|exists:coupons,id',

            'notes' => 'nullable|string|max:1000',

        ];
    }

    public function messages(): array
    {
        return [

            'shipping_email.required' =>
                'Email không được để trống',

            'shipping_phone.required' =>
                'Số điện thoại không được để trống',

            'shipping_address.required' =>
                'Địa chỉ giao hàng không được để trống',

            'payment_method.required' =>
                'Vui lòng chọn phương thức thanh toán',

        ];
    }
}