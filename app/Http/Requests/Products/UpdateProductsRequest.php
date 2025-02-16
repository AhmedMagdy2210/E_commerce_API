<?php

namespace App\Http\Requests\Products;

use App\ApiTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdateProductsRequest extends FormRequest {
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
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'base_price' => 'sometimes|numeric',
            'category_id' => 'sometimes|exists:product_categories,id',
            'details' => 'sometimes|array',
            'details.*.size_id' => 'sometimes|exists:sizes,id',
            'details.*.color_id' => 'sometimes|exists:colors,id',
            'details.*.quantity' => 'sometimes|integer|min:0',
            'details.*.price' => 'sometimes|numeric|min:0',
        ];
    }
    protected function failedValidation(Validator $validator) {
        $this->failedValidationResponse($validator->errors());
    }
}
