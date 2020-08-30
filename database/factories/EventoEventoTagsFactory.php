<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Evento\EventoTag;
use Faker\Generator as Faker;

$factory->define(EventoTag::class, function (Faker $faker) {

    return [
        'evento_id' => 2,
        'tag_id' => 0 //array_unique(range(1,10)),
    ];
});
