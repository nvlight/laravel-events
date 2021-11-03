<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ShortUrl\ShortUrlsCategory as Model;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Model::class, function (Faker $faker) {
    $name = $faker->words(random_int(2,5),true);
    return [
        'parent_id' => 0,
        'user_id' => 1, // need fix this for normal working...
        'name' => $name,
        'slug' => Str::slug($name),
        'img' => null,
    ];
});
