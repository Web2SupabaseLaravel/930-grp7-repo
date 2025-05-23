<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();                                       
            $table->foreignId('patient_id')                    
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->foreignId('practitioner_id')                 
                  ->constrained('practitioners')
                  ->cascadeOnDelete();

            $table->foreignId('service_id')                      
                  ->constrained('services')
                  ->cascadeOnDelete();

            $table->timestamp('appointment_at');               
            $table->enum('status', ['scheduled', 'completed', 'cancelled'])
                  ->default('scheduled');

            $table->timestamps();                                
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
