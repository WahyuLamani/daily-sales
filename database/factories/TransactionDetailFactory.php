<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransactionDetail>
 */
class TransactionDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'transaction_id' => rand(1, Transaction::count()),
            'product_id' => rand(1, Product::count()),
            'jumlah' => rand(1, 5),
            'subtotal' => rand(10, 1000) . 000,
        ];
    }
}
