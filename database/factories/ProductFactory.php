<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Доска25', 'Доска30', 'Доска50', 'Брус300', 'Брус34',  'Брус200', 'Доска55']),
            'price' => $this->faker->randomFloat(null,100, 10000),
            'description' => null,
            'status' => $this->faker->boolean(),
            'category_id' => Category::factory(),
        ];
    }
}
