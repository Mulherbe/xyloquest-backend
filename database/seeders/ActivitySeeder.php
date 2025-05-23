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

        $recurrenceRules = [null, 'daily', 'weekly', 'every_3_days'];

        foreach ($types as $type) {
            $start = now()->addDays(rand(0, 5));
            $end = (rand(0, 1) === 1) ? $start->copy()->addHours(rand(1, 5)) : null;

            Activity::create([
                'user_id'           => $user->id,
                'activity_type_id'  => $type->id,
                'title'             => 'Activité de ' . $type->name,
                'description'       => 'Description pour ' . $type->name,
                'start_date'        => $start,
                'end_date'          => $end,
                'is_recurring'      => rand(0, 1),
                'recurrence_rule'   => $recurrenceRules[array_rand($recurrenceRules)],
                'completed_at'      => rand(0, 1) ? now()->addDays(rand(1, 5)) : null,
            ]);
        }
    }
}
