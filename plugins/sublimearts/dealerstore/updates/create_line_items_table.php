<?php namespace SublimeArts\DealerStore\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateLineItemsTable extends Migration
{

    public function up()
    {
        Schema::create('sublimearts_dealerstore_line_items', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('order_id')->unsigned()->nullable();
            $table->integer('product_id')->unsigned()->nullable();
            $table->integer('product_qty');
            $table->float('value');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sublimearts_dealerstore_line_items');
    }

}
