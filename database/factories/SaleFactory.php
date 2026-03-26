<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = $this->faker->numberBetween(1, 10);
        $price = $this->faker->randomFloat(2, 50, 2000);
        $total_amount = $quantity * $price;
        
        return [
            'product_id' => Product::factory(),
            'quantity' => $quantity,
            'price' => $price,
            'total_amount' => $total_amount,
            'payment_method' => $this->faker->randomElement(['cash', 'card', 'mpesa', 'bank_transfer']),
            'sale_date' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}

