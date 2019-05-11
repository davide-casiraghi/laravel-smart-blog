<?php

use Faker\Generator as Faker;
use Illuminate\Foundation\Auth\User;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(DavideCasiraghi\LaravelSmartBlog\Models\Blog::class, function (Faker $faker) {
    $category = factory(\DavideCasiraghi\LaravelSmartBlog\Models\Category::class)->create();
    $user = User::first();

    return [
        'category_id' => '1',
        'layout' => '1',
        'columns' => '3',
        'article_order' => '1',
        'pagination' => '1',
        'featured_articles' => '1',
        'show_category_title' => '1',
        'show_category_subtitle' => '1',
        'show_category_description' => '1',
        'show_category_image' => '1',
        'show_post_title' => '1',
        'post_linked_titles' => '1',
        'show_post_intro_text' => '1',
        'show_post_author' => '1',
        'link_post_author' => '1',
        'show_create_date' => '1',
        'show_modify_date' => '1',
        'show_publish_date' => '1',
        'show_read_more' => '1',
        'created_by' => $user->id,
    ];
});
