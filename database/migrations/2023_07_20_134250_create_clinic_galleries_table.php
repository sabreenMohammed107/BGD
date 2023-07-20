<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_galleries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id')->nullable();
            $table->foreign('clinic_id')->references('id')->on('doctor_clinics');
            $table->string('image', 250)->nullable();
            $table->integer('active')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clinic_galleries');
    }
};
