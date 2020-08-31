<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Evento\Category;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Category::class, function (Faker $faker) {
    $name = $faker->words(2,true);
    return [
        'parent_id' => 0,
        'user_id' => 34,
        'name' => Str::upper($name),
        'slug' => Str::slug($name),
        'img' => null,
    ];
});