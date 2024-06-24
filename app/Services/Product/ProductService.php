<?php

namespace App\Services\Product;

use App\Events\ProductCreated;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductService
{
    public function store(array $input): JsonResponse
    {
        return $this->handleInput(
            null,
            $input,
            function (Product $product, array $validatedFields) {
                $product->fill($validatedFields);
                $product->save();
                event(new ProductCreated($product));
            });
    }

    public function update(Product $product, array $input): JsonResponse
    {
        return $this->handleInput(
            $product,
            $input,
            function (Product $product, array $validatedFields) {
                $product->update($validatedFields);
            });
    }

    /**
     * @param Product|null $product
     * @param array $input
     * @param \Closure(?Product, array): void $finished
     * @return JsonResponse
     */
    private function handleInput(?Product $product, array $input, \Closure $finished): JsonResponse
    {
        $this->insertAttributes($input);

        $product = $product ?? new Product();
        $finished($product, $input);

        return response()->json(['success' => true]);
    }

    private function insertAttributes(array &$input): void
    {
        $attributes = [];

        if (isset($input['attributes'])) {
            $attributes = array_reduce($input['attributes'],
                function ($acc, $attr) {
                    $acc[$attr['name']] = $attr['val'];
                    return $acc;
                },
                []);
        }

        $input['data'] = json_encode($attributes);
    }
}
