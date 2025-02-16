<?php

namespace App\Http\Requests\Categories;

use App\ApiTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class AddCategoryRequest extends FormRequest {
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
            'name' => 'required|min:5|max:100|unique:product_categories',
            'description' => 'min:5'
        ];
    }
    protected function failedValidation(Validator $validator) {
        $this->failedValidationResponse($validator->errors());
    }
}
