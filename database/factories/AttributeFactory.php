<?php

namespace Database\Factories;

use App\Enums\AttributeName;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attribute>
 */
class AttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(AttributeName::cases())->value, 
            'value' => 50,
            'product_id' => Product::inRandomOrder()->first()->id,
        ];
    }
}
