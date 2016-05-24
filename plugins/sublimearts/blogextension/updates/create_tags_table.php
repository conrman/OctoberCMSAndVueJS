<?php namespace SublimeArts\BlogExtension\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateTagsTable extends Migration
{

    public function up()
    {
        Schema::create('sublimearts_blogextension_tags', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable()->index();
            $table->string('slug')->nullable()->index();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('sublimearts_blogextension_posts_tags', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('post_id')->unsigned();
            $table->integer('tag_id')->unsigned();
            $table->primary(['post_id', 'tag_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('sublimearts_blogextension_tags');
        Schema::dropIfExists('sublimearts_blogextension_posts_tags');
    }

}
