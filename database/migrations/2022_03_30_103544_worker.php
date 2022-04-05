<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Worker extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        if(!Schema::hasTable("Worker")){
            Schema::create("Worker",function(Blueprint $table){

                $table->string("wname");
                $table->integer("wage");
                $table->id("wid");
                $table->string("wpassword");
                $table->bigInteger("wsalary");
                $table->string("wdob");
                $table->string("wemail")->nullable();
                $table->string("wexp")->nullable();
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("Worker");
    }
}
