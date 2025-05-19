<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('activity_type_id')->constrained()->cascadeOnDelete();

            $table->string('title');
            $table->text('description')->nullable();

            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();

            // Pour gérer la répétition
            $table->boolean('is_recurring')->default(false);
            $table->string('recurrence_rule')->nullable(); // ex: daily, weekly, every_3_days

            // Si activité cochée comme "faite"
            $table->timestamp('completed_at')->nullable();
            $table->string('status')->default('pending'); // valeurs : pending, done, skipped
            $table->integer('earned_points')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
