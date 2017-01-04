<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
// CreatePublicHolidaysTable
//
//
class CreatePUBLICHOLIDAYSTABLE extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LEAVE_PUBLIC_HOLIDAYS', function (Blueprint $table) {
            $table->increments('id');
            $table->string('holiday_name');
            $table->date('holiday_date');
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
        Schema::dropIFExists('LEAVE_PUBLIC_HOLIDAYS');
    }
}
