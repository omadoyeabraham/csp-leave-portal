<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLEAVERECLAIMREQUESTSTABLE extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LEAVE_RECLAIM_REQUESTS', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Emp_id')->unsigned();
            $table->string('staff');
            $table->integer('no_of_days');
            $table->string('reason')->nullable();
            $table->date('date_applied')->nullable();
            $table->date('date_replied')->nullable();
            $table->string('line_manager');
            $table->timestamps();
        });

        Schema::table('LEAVE_RECLAIM_REQUESTS',function($table){
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
    Schema::drop('LEAVE_RECLAIM_REQUESTS');
      //  DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
    
}
