<?php

namespace App\Http\Requests\Products;

use App\ApiTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class AddProductRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    use ApiTrait;
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric',
            'category_id' => 'required|exists:product_categories,id',
            'details' => 'required|array',
            'details.*.size_id' => 'required|exists:sizes,id',
            'details.*.color_id' => 'required|exists:colors,id',
            'details.*.quantity' => 'required|integer|min:0',
            'details.*.price' => 'required|numeric|min:0',
        ];
    }
    protected function failedValidation(Validator $validator) {
        $this->failedValidationResponse($validator->errors());
    }
}
