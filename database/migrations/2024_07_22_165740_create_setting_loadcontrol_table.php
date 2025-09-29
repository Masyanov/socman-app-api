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
        Schema::create('setting_loadcontrols', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->boolean('on_load')->default(true);
            $table->boolean('on_extra_questions')->default(true);
            $table->integer('question_recovery_min')->nullable();
            $table->integer('question_load_min')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_loadcontrols');
    }
};
