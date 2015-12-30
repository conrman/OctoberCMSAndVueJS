<?php namespace SublimeArts\Dealers\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateDealerGroupsTable extends Migration
{

    public function up()
    {
        Schema::create('sublimearts_dealers_dealer_groups', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('code')->nullable()->index();
            $table->text('description')->nullable();
            $table->integer('discount')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sublimearts_dealers_dealer_groups');
    }

}
