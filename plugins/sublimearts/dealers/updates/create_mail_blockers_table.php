<?php namespace SublimeArts\Dealers\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateMailBlockersTable extends Migration
{

    public function up()
    {
        Schema::create('sublimearts_dealers_mail_blockers', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('email')->index()->nullable();
            $table->string('template')->index()->nullable();
            $table->integer('dealer_id')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sublimearts_dealers_mail_blockers');
    }

}
