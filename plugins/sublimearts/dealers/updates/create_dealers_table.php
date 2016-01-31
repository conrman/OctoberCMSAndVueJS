<?php namespace SublimeArts\Dealers\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateDealersTable extends Migration
{

    public function up()
    {
        Schema::create('sublimearts_dealers_dealers', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string('username')->unique()->index();
            $table->integer('dealers_group_id')->nullable();
            $table->string('email')->unique()->index();
            $table->string('company_name')->unique()->index();
            $table->string('password');
            $table->string('activation_code')->nullable()->index();
            $table->string('persist_code')->nullable()->index();
            $table->string('reset_password_code')->nullable()->index();
            $table->boolean('is_activated')->default(0);
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('last_login')->nullable();

            $table->integer('country_id')->unsigned()->nullable()->index();
            $table->integer('state_id')->unsigned()->nullable()->index();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('street_address')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('address_finder')->nullable();
            $table->string('phone')->unique()->notnull();
            $table->string('contact_person_first_name')->nullable();
            $table->string('contact_person_last_name')->nullable();
            $table->string('contact_person_designation')->nullable();
            $table->string('contact_person_email')->nullable();
            $table->string('contact_person_phone')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sublimearts_dealers_dealers');
    }

}