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
        Schema::create('appointments', function (Blueprint $table) {
           $table->id('appointment_id'); 
        $table->integer('patiant_id');
        $table->integer('practitioner_id');
        $table->integer('service_id');
        $table->date('appointment_date');
        $table->time('appointment_time');
        $table->string('status');


        $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('practitioner_id')->references('id')->on('practitioners')->onDelete('cascade');
        $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');

        $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
