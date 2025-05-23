<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id('appointment_id');                
            $table->unsignedBigInteger('patient_id');      
            $table->unsignedBigInteger('practitioner_id');
            $table->unsignedBigInteger('service_id');     
            $table->timestamp('appointment_at');           
            $table->timestamp('cancelled_at')->nullable(); 
            $table->timestamps();
        });
    }
    
    
};
