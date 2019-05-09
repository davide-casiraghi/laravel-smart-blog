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

$factory->define(DavideCasiraghi\LaravelSmartBlog\Models\Category::class, function (Faker $faker) {
    $category_name = $faker->name;
    $slug = Str::slug($category_name, '-').rand(10000, 100000);

    return [
        'name:en' => $category_name,
        'slug:en' => $slug,
        'description:en' => $faker->paragraph,
    ];
});
