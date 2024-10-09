<?php

namespace App\Http\Requests\Payment;

use App\Enums\PaymentStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StorePaymentRequest extends FormRequest
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
            'customer_id'   => 'required|integer|exists:customers,id',
            'amount'        => 'required|integer|min:100',
            'payment_date'  => 'nullable|date|before_or_equal:today',
            'status'        => ['required', Rule::enum(PaymentStatus::class)]
        ];
    }

    public function attributes()
    {
        return [
            'customer_id'   => 'معرف الزبون',
            'amount'        => 'الكمية',
            'payment_date'  => 'تاريخ الدفعة',
            'status'        => 'حالة الدفعة'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute مطلوب ',
            'integer'  => ':attribute غير صالح',
            'exists'   => ':attribute غير موجود',
            'date'     => ':attribute غير صالح',
            'enum'     => ':attribute غير موجودة',
            'before_or_equal' => ':attribute يجب أن يكون قبل أو نفس تاريخ اليوم '

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
