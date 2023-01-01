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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 250)->nullable();
            $table->string('email', 250)->nullable();
            $table->string('mobile', 250)->nullable();
            $table->string('img', 250)->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('gender', [0,1])->default(0);
            $table->text('en_detailed_address')->nullable();
            $table->text('dt_detailed_address')->nullable();
            $table->text('postal_code')->nullable();
            $table->text('google_map')->nullable();
            $table->unsignedBigInteger('patient_status_id')->nullable();
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
        Schema::dropIfExists('patients');
    }
};
