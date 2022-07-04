<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Init extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function($table) {
            $table->increments('id');
            $table->string('title');
            $table->float('quantity');
        });

        $initial_items = [
            ['item' => 'Pan', 'quantity' => 3],
            ['item' => 'Bebida', 'quantity' => -5],
            ['item' => 'Almendras', 'quantity' => 0.25],
        ];

        foreach($initial_items as $i)
        {
            $item = new \App\Item();
            $item->title = $i['item'];
            $item->quantity = $i['quantity'];
            $item->save();
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
    }
}
