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
        Schema::create('doctor_clinics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->string('phone', 250)->nullable();
            $table->text('en_detailed_address')->nullable();
            $table->text('dt_detailed_address')->nullable();
            $table->text('postal_code')->nullable();
            $table->text('google_map')->nullable();
            $table->unsignedBigInteger('clinic_status_id')->nullable();
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
        Schema::dropIfExists('doctor_clinics');
    }
};
