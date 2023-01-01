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
            $table->string('en_street', 250)->nullable();
            $table->string('dt_street', 250)->nullable();
            $table->string('postal_code', 250)->nullable();
            $table->text('google_map')->nullable();
            $table->integer('parking_allowed')->default(1);
            $table->integer('home_visit_allowed')->default(1);
            $table->integer('disability_allowed')->default(1);
            $table->unsignedBigInteger('clinic_status_id')->nullable();
            $table->unsignedBigInteger('insurance_type_id')->nullable();
            $table->double('visit_fees',10,2)->nullable();
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
