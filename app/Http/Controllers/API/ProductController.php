<?php

namespace App\Http\Controllers\API;

use App\Enums\ProductStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\Product\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;


class ProductController extends Controller
{
    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }

    public function update(UpdateRequest $request, Product $product, ProductService $productService): JsonResponse
    {
        return $productService->update($product, $request->validated());
    }

    public function store(StoreRequest $request, ProductService $productService): JsonResponse
    {
        return $productService->store($request->validated());
    }
}
