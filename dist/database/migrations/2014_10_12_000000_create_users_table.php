<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LEAVE_USERS', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Emp_id')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->string('username')->unique();
            $table->string('line_manager')->default("default")->nullable();
            $table->integer('COD_from_last_yr')->default(0)->nullable();
            //$table->integer('total_no_of_leave_days')->default(0)->nullable();
            $table->integer('no_of_leave_days_used')->default(0);
            $table->integer('no_of_leave_days_remaining')->default(0)->nullable();
            $table->integer('sick_leave')->default(0)->nullable();
            $table->integer('study_leave')->default(0)->nullable();
            $table->integer('compassionate_leave')->default(0)->nullable();
            $table->integer('paternity_maternity_leave')->default(0)->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::table('LEAVE_USERS',function($table){
          $table->foreign('Emp_id')
                    ->references('Emp_Id')->on('dbo.EMPLOYEES')
                    ->onDelete('cascade');
          //$table->integer('annual_eligible_days')->nullable();
        //  $table->integer('days_earned_this_yr')->nullable();
          $table->integer('confirmation_status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          //DB::statement('SET FOREIGN_KEY_CHECKS = 0');
          Schema::dropIFExists('LEAVE_USERS');
          //DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
