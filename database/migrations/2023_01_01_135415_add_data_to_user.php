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
        Schema::table('users', function (Blueprint $table) {
            //


            $table->enum('gender', ['m', 'f']);
            $table->string('mobile', 250)->nullable();
            $table->string('image', 250)->nullable();

            $table->date('birth_date')->nullable();
            $table->text('details_address')->nullable();
            $table->text('postal_code')->nullable();
            $table->text('google_map')->nullable();

            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities');
            $table->unsignedBigInteger('patient_status_id')->nullable();
            $table->foreign('patient_status_id')->references('id')->on('statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
