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
        Schema::table('cities', function (Blueprint $table) {
            $table->foreign('country_id')->references('id')->on('countries');

        });
        Schema::table('medical_sub_fields', function (Blueprint $table) {
            $table->foreign('medical_field_id')->references('id')->on('medical_fields');

        });
        Schema::table('doctors', function (Blueprint $table) {
            $table->foreign('medical_field_id')->references('id')->on('medical_fields');
            $table->foreign('doctor_position_id')->references('id')->on('doctors_pasitions');
            $table->foreign('doctor_status_id')->references('id')->on('statuses');

        });

        Schema::table('doctor_clinics', function (Blueprint $table) {
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('clinic_status_id')->references('id')->on('statuses');
            $table->foreign('insurance_type_id')->references('id')->on('insurance_types');

        });


        Schema::table('patients', function (Blueprint $table) {
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('patient_status_id')->references('id')->on('statuses');
        });


        Schema::table('doctor_schedules', function (Blueprint $table) {
            $table->foreign('clinic_id')->references('id')->on('doctor_clinics');
            $table->foreign('days_id')->references('id')->on('days');
        });

        //clinic_reviews
        Schema::table('clinic_reviews', function (Blueprint $table) {
            $table->foreign('clinic_id')->references('id')->on('doctor_clinics');
            $table->foreign('user_id')->references('id')->on('users');
        });
        //favourite_doctors

        Schema::table('favourite_doctors', function (Blueprint $table) {
            $table->foreign('clinic_id')->references('id')->on('doctor_clinics');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
