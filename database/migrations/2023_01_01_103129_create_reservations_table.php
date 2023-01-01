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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->unsignedBigInteger('clinic_id')->nullable();
            $table->unsignedBigInteger('reservation_status_id')->nullable();
            $table->text('notes')->nullable();
            $table->date('reservation_date')->nullable();
            $table->time('time_from', $precision = 0);
            $table->time('time_to', $precision = 0);
            $table->boolean('other_flag')->default(false);
            $table->string('patient_name', 250)->nullable();
            $table->string('patient_mobile', 250)->nullable();
            $table->string('patient_address', 250)->nullable();
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
        Schema::dropIfExists('reservations');
    }
};
