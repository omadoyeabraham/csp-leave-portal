<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLEAVEREQUESTSTABLE extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LEAVE_REQUESTS', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('Emp_id')->unsigned();
          $table->string('staff_name');
          $table->string('line_manager')->nullable();
          $table->string('start_date')->nullable();
          $table->string('end_date')->nullable();
          $table->integer('no_of_days');
          $table->string('leave_type');
          $table->string('date_applied');
          $table->string('comments_by_staff')->nullable();
          $table->string('comments_by_linemanager')->nullable();
          $table->string('date_replied')->nullable();
          $table->string('application_status');
          $table->integer('COD_from_last_yr')->nullable();
          $table->integer('days_gained_this_yr')->nullable();
          $table->timestamps();
        });

        Schema::table('LEAVE_REQUESTS',function($table){
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
        Schema::drop('LEAVE_REQUESTS');
      //  DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
