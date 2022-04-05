<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Items extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('Items')) {
            //Create Table Here
            Schema::create("Items",function(Blueprint $table){
                $table->bigIncrements('itemId');
                $table->string("itemName");
                $table->string("itemType");
                $table->integer("itemPrice");
                $table->string("itemDesc");
                $table->string("itemImg");
                $table->timestamps();
                $table->unsignedBigInteger("uid_resId");//will become forign key
                $table->foreign("uid_resId")->references("resId")->on("Restaurant")->onDelete('cascade');

                
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
        //Delete Table Here
        if(Schema::hasTable("Items")){
            Schema::table('Items', function (Blueprint $table) {
                $table->dropForeign(['uid_resId']);
            });
            Schema::dropIfExists("Items");
        }
        
        
    }
}
