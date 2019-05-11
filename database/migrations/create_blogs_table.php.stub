<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogsTable extends Migration
{
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('category_id')->nullable();
            $table->integer('layout');
            $table->integer('columns');
            
            $table->integer('article_order');
            $table->integer('pagination');
            $table->integer('featured_articles');

            $table->boolean('show_category_title')->nullable();
            $table->boolean('show_category_subtitle')->nullable();
            $table->boolean('show_category_description')->nullable();
            $table->boolean('show_category_image')->nullable();
            
            $table->boolean('show_post_title')->nullable();
            $table->boolean('post_linked_titles')->nullable();
            $table->boolean('show_post_intro_text')->nullable();
            
            $table->boolean('show_post_author')->nullable();
            $table->boolean('link_post_author')->nullable();
            
            $table->boolean('show_create_date')->nullable();
            $table->boolean('show_modify_date')->nullable();
            $table->boolean('show_publish_date')->nullable();
            
            $table->boolean('show_read_more')->nullable();
            
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
