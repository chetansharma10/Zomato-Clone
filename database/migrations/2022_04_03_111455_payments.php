<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Payments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Payments Table
        if(!Schema::hasTable("Payments")){
            Schema::create("Payments",function(Blueprint $table){
                $table->bigIncrements("payId");
                
                $table->string("paymentId")->nullable();
                $table->string("payerId")->nullable();
                $table->string("time");
                $table->string("email");
                $table->string("status");
                $table->bigInteger("total");
                $table->unsignedBigInteger("uid_fk");
               
                $table->foreign("uid_fk")->references("id")->on("Employee")->onDelete("cascade");
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
        Schema::table('Payments', function (Blueprint $table) {
            $table->dropForeign(['uid_fk']);
        });
        Schema::dropIfExists('Payments');
    }
}
