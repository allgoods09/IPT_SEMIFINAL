<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $costPrice = $this->faker->randomFloat(2, 5, 1500);
        $sellingPrice = $costPrice * $this->faker->randomFloat(2, 1.2, 2.5);
        
        $productNames = [
            'iPhone 15 Pro', 'Samsung Galaxy S24', 'MacBook Air M2', 'Dell XPS 13', 'Sony WH-1000XM5',
            'Nike Air Max 90', 'Adidas Ultraboost', 'Levis 501 Jeans', 'Ray-Ban Wayfarer', 'Gucci Belt',
            'Organic Apples (kg)', 'Fresh Milk 2L', 'Bread Loaf', 'Chicken Breast (kg)', 'Rice 5kg',
            'Sofa Set', 'Dining Table', 'Office Chair', 'Bookshelf', 'Coffee Table',
            'Wilson Tennis Racket', 'Nike Football', 'Yoga Mat', 'Dumbbells 10kg', 'Treadmill'
        ];

        return [
            'category_id' => Category::factory(),
            'name' => $this->faker->randomElement($productNames),
            'description' => $this->faker->paragraph(),
            'cost_price' => $costPrice,
            'selling_price' => $sellingPrice,
            'stock_quantity' => $this->faker->numberBetween(1, 500),
            'reorder_level' => $this->faker->numberBetween(10, 50),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}

