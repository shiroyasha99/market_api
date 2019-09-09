<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('markets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name");
            $table->string("address");
            $table->integer("image_id")->default(0);
            $table->string("phone");
            $table->string("longtude");
            $table->string("latitude");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('markets');
    }
}
