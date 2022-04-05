<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Employee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        
        if(!Schema::hasTable("Employee")){
            Schema::create('Employee', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string("fullname",100)->unique();
                $table->string("email",100)->unique();
                $table->string("password");
                $table->string("usertype");
                $table->string("userPic")->default("");
                $table->timestamp("joinedOn");
                $table->timestamps();
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
        Schema::dropIfExists('Employee');
    }
}
