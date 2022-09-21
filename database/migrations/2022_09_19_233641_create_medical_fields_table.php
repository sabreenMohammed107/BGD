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
        Schema::create('medical_fields', function (Blueprint $table) {
            $table->id();
            $table->string('field_enname', 250)->nullable();
            $table->string('field_dtname', 250)->nullable();
            $table->string('field_img', 250)->nullable();
            $table->longText('field_enoverview')->nullable();
            $table->longText('field_dtoverview')->nullable();
            $table->integer('order')->default(1);
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
        Schema::dropIfExists('medical_fields');
    }
};
