<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Evento\EventoCategory;
use Faker\Generator as Faker;

$factory->define(EventoCategory::class, function (Faker $faker) {
    return [
        'evento_id' => 2,
        'category_id' => array_rand(
            DB::table('evento_categories')
                ->select('id')->get()->pluck('id')->toArray()
        ),
    ];
});
