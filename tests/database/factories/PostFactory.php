<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(DavideCasiraghi\LaravelSmartBlog\Models\Post::class, function (Faker $faker) {
    $post_title = $faker->name;
    $slug = Str::slug($post_title, '-').rand(10000, 100000);

    return [
        'title:en' => $post_title,
        'intro_text:en' => $faker->sentence($nbWords = 10, $variableNbWords = true),
        'slug:en' => $slug,
        'body:en' => $faker->paragraph,
    ];
});
