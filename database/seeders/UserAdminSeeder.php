<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = Hash::make('inipasswordadmin');
        User::create([
            'name' => "Administrator",
            'email' => "admin@administrator.id",
            'password' => $password,
            'is_admin' => true,
        ]);
    }
}
