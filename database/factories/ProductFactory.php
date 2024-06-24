<?php

namespace Database\Factories;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    private string $json = '{
                                "Цвет": "черный",
                                "Размер": "XL"
                            }';

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'article' => $this->faker->unique()->word(),
            'name' => $this->faker->sentence(3),
            'status' => $this->faker->randomElement(ProductStatus::toArray()),
            'data' => $this->faker->randomElement([null, $this->json]),
        ];
    }
}
