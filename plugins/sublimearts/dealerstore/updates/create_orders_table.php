<?php namespace SublimeArts\DealerStore\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateOrdersTable extends Migration
{

    public function up()
    {
        Schema::create('sublimearts_dealerstore_orders', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('dealer_id')->unsigned()->nullable();
            $table->integer('total_value')->nullable();
            $table->boolean('is_shipped')->default(0);
            $table->string('shipping_provider')->nullable();
            $table->string('tracking_number')->unique()->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sublimearts_dealerstore_orders');
    }

}
