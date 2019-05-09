<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('created_by')->nullable();

            $table->integer('category_id')->nullable();
            $table->string('status')->default('2');
            $table->boolean('featured')->default(0);

            $table->string('introimage')->nullable();
            $table->string('introimage_alt')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
