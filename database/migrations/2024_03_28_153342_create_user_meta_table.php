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
        Schema::create('user_metas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->date('birthday')->nullable();
            $table->string('tel')->nullable();
            $table->string('telegram_id')->nullable();
            $table->string('position')->nullable();
            $table->string('number')->nullable();
            $table->string('tel_mother')->nullable();
            $table->string('tel_father')->nullable();
            $table->string('comment')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_metas');
    }
};
