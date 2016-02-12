<?php namespace SublimeArts\DealerStore\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateProductsTable extends Migration
{

    public function up()
    {
        Schema::create('sublimearts_dealerstore_products', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string('name')->unique();
            $table->string('code')->unique();
            $table->string('tagline');
            $table->longText('description');
            $table->float('fob_price');
            $table->float('dealer_price');
            $table->float('retail_price');
            $table->boolean('is_activated')->default(0);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sublimearts_dealerstore_products');
    }

}
