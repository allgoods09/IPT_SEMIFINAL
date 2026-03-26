<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $names = [
            'Electronics', 'Clothing', 'Food & Beverages', 'Home & Garden', 'Sports & Outdoors',
            'Books', 'Toys', 'Automotive', 'Health & Beauty', 'Office Supplies',
            'Furniture', 'Jewelry', 'Shoes', 'Bags', 'Tools',
            'Kitchenware', 'Baby Products', 'Pet Supplies', 'Arts & Crafts', 'Musical Instruments'
        ];

        return [
            'name' => $this->faker->randomElement($names),
            'description' => $this->faker->sentence(8),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'created_at' => $this->faker->dateTimeBetween('-1year', 'now'),
        ];
    }
}

