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
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('team_code');
            $table->date('date_of_test');
            $table->string('full_name');
            $table->string('photo')->nullable();
            $table->date('date_of_birth');
            $table->string('leading_leg');
            $table->string('position');
            $table->string('status');
            $table->float('height');
            $table->float('weight');
            $table->float('body_mass_index');
            $table->float('push_ups');
            $table->float('pull_ups');
            $table->float('ten_m');
            $table->float('twenty_m');
            $table->float('thirty_m');
            $table->float('long_jump');
            $table->float('vertical_jump_no_hands');
            $table->float('vertical_jump_with_hands');
            $table->float('illinois_test');
            $table->float('pause_one');
            $table->float('pause_two');
            $table->float('pause_three');
            $table->float('step');
            $table->float('mpk');
            $table->string('level');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tests');
    }

};
