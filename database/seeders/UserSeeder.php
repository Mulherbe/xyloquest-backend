<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Fred Dev',
            'email' => 'fred@example.com',
            'password' => Hash::make('password'),
        ]);

        User::factory(2)->create();
    }
}
