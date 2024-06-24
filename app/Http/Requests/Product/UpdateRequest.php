<?php

namespace App\Http\Requests\Product;

use App\Enums\ProductStatus;
use App\Enums\UserRoles;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateRequest extends FormRequest
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
        $rules = [
            'name' => 'required|min:10',
            'status' => [new Enum(ProductStatus::class)],
            'attributes' => 'array',
        ];

        $this->resolveAppendArticleRule($rules);

        return $rules;
    }

    private function resolveAppendArticleRule(array &$rules): void
    {
        /** @var User $user */
        $user = auth()->user();

        if ($user->role() !== UserRoles::Admin) {
            return;
        }

        $rules['article'] = [
            'required',
            'regex:/^[a-zA-Z0-9]+$/',
            Rule::unique('products', 'article')->ignore($this->product->id)
        ];
    }
}
