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
            $table->integer('group_id')->nullable();
            $table->string('email')->unique()->index();
            $table->string('company_name')->unique()->index();
            $table->string('password');
            $table->string('activation_code')->nullable()->index();
            $table->string('persist_code')->nullable();
            $table->string('reset_password_code')->nullable()->index();
            $table->boolean('is_activated')->default(0);
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('membership_requested_at')->nullable();
            $table->timestamp('last_login')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sublimearts_dealers_dealers');
    }

}
