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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('team_code')->nullable();
            $table->string('pain')->nullable();
            $table->string('local')->nullable();
            $table->string('sleep')->nullable();
            $table->string('sleep_time')->nullable();
            $table->string('moral')->nullable();
            $table->string('physical')->nullable();
            $table->string('presence_checkNum')->nullable();
            $table->string('cause')->nullable();
            $table->string('recovery')->nullable();
            $table->string('load')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
