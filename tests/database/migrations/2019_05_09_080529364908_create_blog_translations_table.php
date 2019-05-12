<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('blog_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('blog_id')->unsigned();
            
            $table->string('name');
            $table->string('slug');
            $table->string('locale')->index();

            $table->unique(['blog_id', 'locale']);
            $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('blog_translations');
    }
}
