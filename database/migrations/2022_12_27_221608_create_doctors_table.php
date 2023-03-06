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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_editor')->default(false);
            $table->rememberToken();
            $table->string('mobile', 250)->nullable();
            $table->string('img', 250)->nullable();
            $table->text('en_overview')->nullable();
            $table->text('dt_overview')->nullable();
            $table->text('en_brief')->nullable();
            $table->text('dt_brief')->nullable();
            $table->string('licence_file',255)->nullable();
            $table->enum('verified', [0,1])->default(0);
            $table->unsignedBigInteger('doctor_position_id')->nullable();
            $table->unsignedBigInteger('doctor_status_id')->nullable();

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
        Schema::dropIfExists('doctors');
    }
};
