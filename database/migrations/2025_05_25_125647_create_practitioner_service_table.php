<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePractitionerServiceTable extends Migration
{
    public function up()
    {
        Schema::create('practitioner_service', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('practitioner_id');
            $table->unsignedBigInteger('service_id');

            $table->foreign('practitioner_id')->references('id')->on('practitioners')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('practitioner_service');
    }
}

