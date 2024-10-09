<?php

namespace App\Http\Requests\Customer;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCustomerRequest extends FormRequest
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
            'name' => 'sometimes|required|string|max:20',
            'email' => 'sometimes|required|email',
            'phone' => 'sometimes|required|min:4|max:10'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'اسم الزبون',
            'email' => 'البريد الإلكتروني',
            'phone' => 'رقم الهاتف'
        ];
    }
    public function messages()
    {
        return [
            'required' => ':attribute مطلوب',
            'email' => ':attribute غير صحيح',
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
