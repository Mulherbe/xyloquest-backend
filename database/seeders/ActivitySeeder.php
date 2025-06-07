<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\User;
use App\Models\ActivityType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        $plantesType = ActivityType::where('name', 'Plantes')->first();
        $travailType = ActivityType::where('name', 'Travail')->first();
        $sportType   = ActivityType::where('name', 'Sport')->first();

        $startDate = Carbon::parse('2025-05-23');
        $endDate = Carbon::parse('2025-07-01');

        // 🌱 Arrosage des plantes tous les 2 jours (8h–9h)
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDays(2)) {
            Activity::create([
                'user_id' => $user->id,
                'activity_type_id' => $plantesType->id,
                'title' => 'Arrosage des tomates',
                'description' => 'Arrosage régulier du potager',
                'start_date' => $date->copy()->setTime(8, 0),
                'end_date' => $date->copy()->setTime(9, 0),
                'is_recurring' => false,
                'recurrence_rule' => null,
            ]);
        }

        // 💼 Travail : 1h/jour les jours ouvrés (21h–22h)
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            if ($date->isWeekday()) {
                Activity::create([
                    'user_id' => $user->id,
                    'activity_type_id' => $travailType->id,
                    'title' => 'Session de travail',
                    'description' => 'Travail sur projet ou tâche pro',
                    'start_date' => $date->copy()->setTime(21, 0),
                    'end_date' => $date->copy()->setTime(22, 0),
                    'is_recurring' => false,
                    'recurrence_rule' => null,
                ]);
            }
        }

        // 🏃‍♂️ Sport : 2–3 fois/semaine (18h–19h)
        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            $daysAvailable = collect(range(0, 6))->shuffle()->take(rand(2, 3));

            foreach ($daysAvailable as $dayOffset) {
                $day = $currentDate->copy()->startOfWeek()->addDays($dayOffset);
                if ($day->lte($endDate)) {
                    Activity::create([
                        'user_id' => $user->id,
                        'activity_type_id' => $sportType->id,
                        'title' => 'Séance de course',
                        'description' => 'Course à pied 1h',
                        'start_date' => $day->copy()->setTime(18, 0),
                        'end_date' => $day->copy()->setTime(19, 0),
                        'is_recurring' => false,
                        'recurrence_rule' => null,
                    ]);
                }
            }

            $currentDate->addWeek();
        }

        // 🧹 Tâche ménagère : 1x/semaine (dimanche 16h–17h)
        for ($date = $startDate->copy()->next(Carbon::SUNDAY); $date->lte($endDate); $date->addWeek()) {
            Activity::create([
                'user_id' => $user->id,
                'activity_type_id' => $travailType->id,
                'title' => 'Entretien de l\'appartement',
                'description' => 'Nettoyage, rangement, etc.',
                'start_date' => $date->copy()->setTime(16, 0),
                'end_date' => $date->copy()->setTime(17, 0),
                'is_recurring' => false,
                'recurrence_rule' => null,
            ]);
        }
    }
}
