<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'maker_id' => User::factory(),
            'category_id' => Category::factory(),
            'name' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'material' => fake()->randomElement(['Wood', 'Clay', 'Wool', 'Metal', 'Glass', 'Leather']),
            'production_time' => fake()->numberBetween(1, 21) . ' days',
            'complexity' => fake()->randomElement(['Low', 'Medium', 'High']),
            'sustainability' => fake()->sentence(),
            'unique_features' => fake()->sentence(),
            'is_approved' => fake()->boolean(80),
        ];
    }
}
