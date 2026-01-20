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
        Schema::create('book_calls', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->string('email')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_calls');
    }
};
