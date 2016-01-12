<?php namespace SublimeArts\Forms\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateLeadsTable extends Migration
{

    public function up()
    {
        Schema::create('sublimearts_forms_leads', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string("fullname");
            $table->string("email")->unique();
            $table->string("type");
            $table->text("message");
            $table->boolean("subscribed")->default(0);
            $table->timestamp("subscribed_at");

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sublimearts_forms_leads');
    }

}
