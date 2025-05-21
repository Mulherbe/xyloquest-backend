<?php

namespace Database\Seeders;

use App\Models\MonthlyGoal;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class MonthlyGoalSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create(); // Prend le premier utilisateur ou en crée un

        $now = Carbon::now();

        MonthlyGoal::updateOrCreate(
            [
                'user_id' => $user->id,
                'year' => $now->year,
                'month' => $now->month,
            ],
            [
                'goal_points' => 120, // Exemple : objectif de 120 points
            ]
        );
    }
}
