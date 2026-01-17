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
        Schema::create('homes', function (Blueprint $table) {
            $table->id();
            // Hero
            $table->string('hero_ar_title');
            $table->string('hero_en_title');
            $table->string('hero_ar_subtitle');
            $table->string('hero_en_subtitle');
            $table->string('hero_ar_button_text');
            $table->string('hero_en_button_text');
            $table->string('hero_background')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homes');
    }
};
