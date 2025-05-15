<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\User;
use App\Models\ActivityType;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $types = ActivityType::all();

        foreach ($types as $type) {
            Activity::create([
                'user_id' => $user->id,
                'activity_type_id' => $type->id,
                'title' => 'Activité de ' . $type->name,
                'description' => 'Description pour ' . $type->name,
                'start_date' => now()->addDays(rand(0, 5)),
                'end_date' => now()->addDays(rand(6, 10)),
                'is_recurring' => rand(0, 1),
            ]);
        }
    }
}
