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
        Schema::create('player_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained('users')->onDelete('cascade');
            $table->date('date_of_test')->nullable();
            $table->string('position')->nullable();
            $table->string('status')->nullable();
            $table->float('height')->nullable();
            $table->float('weight')->nullable();
            $table->float('body_mass_index')->nullable();
            $table->integer('push_ups')->nullable();
            $table->integer('pull_ups')->nullable();
            $table->float('ten_m')->nullable();
            $table->float('twenty_m')->nullable();
            $table->float('thirty_m')->nullable();
            $table->float('long_jump')->nullable();
            $table->float('vertical_jump_no_hands')->nullable();
            $table->float('vertical_jump_with_hands')->nullable();
            $table->float('illinois_test')->nullable();
            $table->float('pause_one')->nullable();
            $table->float('pause_two')->nullable();
            $table->float('pause_three')->nullable();
            $table->string('step')->nullable();
            $table->float('mpk')->nullable();
            $table->string('level')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_tests');
    }
};
