<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compositions', function (Blueprint $table) {
            $table->unsignedBigInteger('sku_id');
            $table->unsignedBigInteger('component_id');

            $table->foreign('sku_id')
                  ->references('id')->on('skus')
                  ->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('component_id')
                  ->references('id')->on('components')
                  ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compositions');
    }
}
