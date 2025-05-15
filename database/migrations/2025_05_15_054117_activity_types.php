<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('activity_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color')->nullable(); // ex: #ff00ff
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_types');
    }
};
