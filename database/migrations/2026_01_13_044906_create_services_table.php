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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('ar_title');
            $table->string('en_title');
            $table->text('ar_description');
            $table->text('en_description');
            $table->string('ar_feature_one')->nullable();
            $table->string('en_feature_one')->nullable();
            $table->string('ar_feature_two')->nullable();
            $table->string('en_feature_two')->nullable();
            $table->string('ar_feature_three')->nullable();
            $table->string('en_feature_three')->nullable();
            $table->string('ar_button_text');
            $table->string('en_button_text');
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->string('icon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
