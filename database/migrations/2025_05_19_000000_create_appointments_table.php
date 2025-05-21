<?php
// database/migrations/2025_05_19_000000_create_appointments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('practitioner_id')->constrained('practitioners')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->enum('status', ['scheduled','cancelled','completed'])->default('scheduled');
            $table->timestamps();

            $table->unique(['practitioner_id','appointment_date','appointment_time'], 
                           'unique_practitioner_datetime');
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
