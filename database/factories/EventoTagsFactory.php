<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Evento\Tag;
use Faker\Generator as Faker;
use \Illuminate\Support\Str;

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'name' => Str::upper($faker->word()),
        'color' => $faker->hexColor, // unique()->slug(2),
        'img' => null,
    ];
});
