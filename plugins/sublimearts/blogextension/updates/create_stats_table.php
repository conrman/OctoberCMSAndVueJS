<?php namespace SublimeArts\BlogExtension\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateStatsTable extends Migration
{

    public function up()
    {
        Schema::create('sublimearts_blogextension_stats', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('post_id')->notnull()->unsigned();
            $table->integer('like_count')->notnull()->unsigned()->default(0);
            $table->integer('comment_count')->notnull()->unsigned()->default(0);
            $table->integer('share_count')->notnull()->unsigned()->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('sublimearts_blogextension_stats');
    }

}
