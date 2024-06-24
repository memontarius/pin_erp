<?php

namespace App\Http\Requests\Product;

use App\Enums\ProductStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreRequest extends FormRequest
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
            'article' => 'required|regex:/^[a-zA-Z0-9]+$/|unique:products',
            'name' => 'required|min:10',
            'status' => [new Enum(ProductStatus::class)],
            'attributes' => 'array',
        ];
    }
}
