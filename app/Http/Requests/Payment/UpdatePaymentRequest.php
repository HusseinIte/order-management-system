<?php

namespace App\Http\Requests\Payment;

use App\Enums\PaymentStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdatePaymentRequest extends FormRequest
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
            'customer_id'   => 'sometimes|required|integer|exists:customers,id',
            'amount'        => 'sometimes|required|integer|min:100',
            'payment_date'  => 'sometimes|required|date',
            'status'        => ['sometimes', 'required', Rule::enum(PaymentStatus::class)]
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
