<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Evento\Tag;
use Faker\Generator as Faker;
use \Illuminate\Support\Str;

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'name' => Str::upper($faker->word()),
        'user_id' => 34,
        'color' => $faker->hexColor,
        'img' => null,
    ];
});
