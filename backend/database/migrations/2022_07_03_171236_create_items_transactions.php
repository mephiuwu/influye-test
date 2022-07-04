<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_item');
            $table->float('quantity');
            $table->string('details');
            $table->timestamps();

            $table->foreign('id_item')->references('id')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items_transactions');
    }
}
