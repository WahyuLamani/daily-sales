<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => rand(1, User::count()),
            'tanggal_transaksi' => fake()->dateTimeBetween('-2 years', 'now', 'WITA'),
            'total_harga' => rand(1, 100) . '000',
            'status_pembayaran' => 'lunas',
        ];
    }
}
