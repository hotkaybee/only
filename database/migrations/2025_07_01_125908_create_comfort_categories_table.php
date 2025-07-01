<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comfort_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20); // Первая, Вторая, Третья и т.д.
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('level'); // Уровень категории (1, 2, 3...)
            $table->timestamps();

            $table->unique('level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comfort_categories');
    }
};
