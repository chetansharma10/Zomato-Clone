<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Restaurant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('Restaurant')) {
            
            Schema::create('Restaurant', function (Blueprint $table) {
                $table->bigIncrements('resId');
                $table->string('resName')->unique();
                $table->string("resLoc")->unique();
                $table->timestamp("resJoin");
                $table->string("resAddress")->unique();
                $table->string("resOwnerName");
                $table->string("resOpen");
                $table->string("resClose");
                $table->bigInteger("resMobile")->unique();                
                $table->timestamps();
                $table->unsignedBigInteger("uid_fk");//will become forign key
                $table->foreign("uid_fk")->references("id")->on("Employee")->onDelete('cascade');
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
        //
        Schema::table('Restaurant', function (Blueprint $table) {
            $table->dropForeign(['uid_fk']);
        });
        Schema::dropIfExists('Restaurant');
    }
}
