<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('team_code');
            $table->date('date');
            $table->timeTz('start', precision: 0);
            $table->timeTz('finish', precision: 0);
            $table->string('class');
            $table->string('count_players')->nullable();
            $table->string('desc')->nullable();
            $table->integer('recovery')->nullable();
            $table->integer('load')->nullable();
            $table->string('link_docs')->nullable();
            $table->boolean('confirmed')->default(false);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training');
    }
};
