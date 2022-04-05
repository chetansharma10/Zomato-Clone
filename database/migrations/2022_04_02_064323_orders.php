<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Orders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable("Orders")){
            Schema::create("Orders",function(Blueprint $table){
                $table->bigIncrements("orderId");
                $table->integer("itemId");
            
                $table->timestamps();
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
        Schema::table('Orders', function (Blueprint $table) {
            $table->dropForeign(['uid_fk']);
        });
        Schema::dropIfExists('Orders');
    }
}
