<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{

    public $categorySeed = [
        'Elektronik',
        'Pakaian',
        'Perabotan Rumah Tangga',
        'Kecantikan',
        'Olahraga',
        'Mainan dan Hobi'
    ];

    public function run()
    {
        foreach ($this->categorySeed as $seed) {
            ProductCategory::create([
                'nama_kategori' => $seed
            ]);
        }
    }
}
