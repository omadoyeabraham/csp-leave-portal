<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRECLAIMEDDAYSTABLE extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('RECLAIMED_DAYS', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Emp_id')->unsigned();
            $table->string('staff');
            $table->integer('no_of_days');
            $table->string('reason')->nullable();
            $table->timestamps();
        });

        Schema::table('RECLAIMED_DAYS',function($table){
          $table->foreign('Emp_id')
                    ->references('Emp_id')->on('dbo.EMPLOYEES')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

      //  DB::statement('SET FOREIGN_KEY_CHECKS = 0');
      Schema::drop('RECLAIMED_DAYS');
      //  DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
