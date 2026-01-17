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
            // Services
            // Portfolio
            // Why
            $table->string('why_azrar_ar_title');
            $table->string('why_azrar_en_title');
            // About
            $table->string('about_ar_title');
            $table->string('about_en_title');
            $table->text('about_ar_paragraph_one');
            $table->text('about_en_paragraph_one');
            $table->text('about_ar_paragraph_two')->nullable();
            $table->text('about_en_paragraph_two')->nullable();
            $table->string('about_ar_button_text');
            $table->string('about_en_button_text');
            // Meta
            $table->string('meta_ar_title');
            $table->string('meta_en_title');
            $table->string('meta_ar_description');
            $table->string('meta_en_description');
            $table->string('meta_ar_button_text');
            $table->string('meta_en_button_text');
            // concept to impact 
            $table->string('journey_ar_title');
            $table->string('journey_en_title');
            $table->text('journey_ar_paragraph_one');
            $table->text('journey_en_paragraph_one');
            $table->text('journey_ar_paragraph_two')->nullable();
            $table->text('journey_en_paragraph_two')->nullable();
            $table->string('journey_image')->nullable();
            $table->string('journey_ar_button_text')->nullable();
            $table->string('journey_en_button_text')->nullable();
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
