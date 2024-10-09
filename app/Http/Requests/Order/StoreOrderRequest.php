<?php

namespace App\Http\Requests\Order;

use App\Enums\OrderStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
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
            'customer_id'  => 'required|exists:customers,id',
            'product_name' => 'required|max:255',
            'quantity'     => 'required|integer|min:1',
            'price'        => 'required|integer|min:1',
            'order_date'   => 'required|date'
        ];
    }
    public function attributes()
    {
        return [
            'customer_id'    => 'معرف الزبون',
            'product_name'   => 'اسم المنتج',
            'quantity'       => 'الكمية',
            'price'          => 'السعر',
            'order_date'     => 'تاريخ الطلب'
        ];
    }
    public function messages()
    {
        return [
            'required' => ':attribute مطلوب',
            'exists'   => ':attribute غير موجود',
            'date'     => ':attribute غير صالح'
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'errors' => $validator->errors()
        ], 422));
    }
}
