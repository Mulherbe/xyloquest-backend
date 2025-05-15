<?php

namespace Database\Seeders;

use App\Models\Log;
use App\Models\User;
use App\Models\Activity;
use Illuminate\Database\Seeder;

class LogSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $activities = Activity::all();

        foreach ($activities as $activity) {
            Log::create([
                'user_id' => $user->id,
                'activity_id' => $activity->id,
                'action' => 'created',
            ]);
        }
    }
}
