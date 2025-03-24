<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class MasterUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Valter Tonon',
            'email' => 'tononvalter@gmail.com',
            'password' => Hash::make('12345678'),
            'is_admin' => true,
        ]);
    }
}
