<?php

namespace App\Http\Requests\Auth;

use App\ApiTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest {
    use ApiTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'username' => 'required|min:5|max:50|unique:users|regex:/^[a-zA-Z0-9_.]+$/',
            'email' => 'required|email|unique:users',
            'first_name' => 'required|min:5|max:50|regex:/^[\pL\-]+$/u',
            'last_name' => 'required|min:5|max:50|regex:/^[\pL\-]+$/u',
            'password' => 'required|string|min:8|max:150',
            'phone' => 'required'
        ];
    }
    protected function failedValidation(Validator $validator) {
        $this->failedValidationResponse($validator->errors());
    }
}
