<?php namespace SublimeArts\Dealers\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateInfoTable extends Migration
{

    public function up()
    {
        Schema::create('sublimearts_dealers_info', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->integer('dealer_id')->unique()->index();
            $table->integer('country_id')->unsigned()->nullable()->index();
            $table->integer('state_id')->unsigned()->nullable()->index();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('street_address')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('phone')->nullable();

            $table->string('contact_person_first_name');
            $table->string('contact_person_last_name');
            $table->string('contact_person_designation');
            $table->string('contact_person_email');
            $table->string('contact_person_phone');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sublimearts_dealers_info');
    }

}
