<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('position_comfort_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('position_id')->constrained('positions')->onDelete('cascade');
            $table->foreignId('comfort_category_id')->constrained('comfort_categories')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['position_id', 'comfort_category_id'], 'position_comfort_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('position_comfort_categories');
    }
};
