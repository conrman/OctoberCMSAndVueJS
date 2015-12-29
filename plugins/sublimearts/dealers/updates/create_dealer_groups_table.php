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

        Schema::create('sublimearts_dealers_dealers_groups', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('dealer_id')->unsigned();
            $table->integer('dealer_group_id')->unsigned();
            $table->primary(['dealer_id', 'dealer_group_id'], 'dealer_group');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sublimearts_dealers_dealer_groups');
        Schema::dropIfExists('sublimearts_dealers_dealers_groups');
    }

}
