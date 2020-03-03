<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkubatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skubatch', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('batch', 255);
            $table->string('sku', 255);
            $table->string('gtin', 255);
            $table->string('expirydate', 255);
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
        Schema::dropIfExists('skubatch');
    }
}
