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
        Schema::table('bdg_datas', function (Blueprint $table) {
            //
            $table->string('home_dt_video', 250)->nullable();
            $table->text('home_dt_tutorial')->nullable();
            $table->text('dt_policy')->nullable();
            $table->text('en_policy')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bdg_datas', function (Blueprint $table) {
            //
        });
    }
};
