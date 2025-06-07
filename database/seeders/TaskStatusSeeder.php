<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskStatusSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('task_statuses')->insert([
            ['id' => 1, 'name' => 'À faire', 'order' => 1],
            ['id' => 2, 'name' => 'En cours', 'order' => 2],
            ['id' => 3, 'name' => 'Fait', 'order' => 3],
        ]);
    }
}
