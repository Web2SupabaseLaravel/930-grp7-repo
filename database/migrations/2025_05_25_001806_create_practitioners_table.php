<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('practitioners', function (Blueprint $table) {
            $table->id('Practitioners_id'); // Primary key
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('specialization')->nullable();
            $table->text('qualifications')->nullable();
            $table->string('contact')->nullable();
            $table->string('working_hours')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('practitioners');
    }
};
