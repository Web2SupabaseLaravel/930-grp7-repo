<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

           
            $table->foreignId('patient_id')
                  ->constrained('users')
                  ->onDelete('cascade');

         
            $table->foreignId('practitioner_id')
                  ->constrained('practitioners')
                  ->onDelete('cascade');

            
            $table->foreignId('service_id')
                  ->constrained('services')
                  ->onDelete('cascade');

            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->enum('status', ['scheduled','cancelled','completed'])
                  ->default('scheduled');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
