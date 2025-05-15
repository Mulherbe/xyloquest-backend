<?php

namespace Database\Seeders;

use App\Models\ActivityType;
use Illuminate\Database\Seeder;

class ActivityTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Sport', 'color' => '#FF5733'],
            ['name' => 'Travail', 'color' => '#3498DB'],
            ['name' => 'Plantes', 'color' => '#27AE60'],
            ['name' => 'Lecture', 'color' => '#8E44AD'],
        ];

        foreach ($types as $type) {
            ActivityType::create($type);
        }
    }
}
