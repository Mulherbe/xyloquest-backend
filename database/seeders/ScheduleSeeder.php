<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\Activity;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $activities = Activity::where('is_recurring', true)->get();

        foreach ($activities as $activity) {
            Schedule::create([
                'activity_id' => $activity->id,
                'recurrence_rule' => 'every_3_days',
                'next_occurrence' => now()->addDays(3),
            ]);
        }
    }
}
