<?php

use App\Models\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(User::class, function (Faker $faker) {
    $active = $faker->boolean;
    $statusActive = $faker->boolean;
    $phoneActive = $faker->boolean;
    return [
        'name' => $faker->name,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->unique()->phoneNumber,
        'phone_verified' => $phoneActive,

        //'email_verified_at' => $active ? '' : now(),
        //'email_verified_at' => '',
        'email_verified_at' => now(),

        //'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'password' => '$2y$10$f8DTh5RLBwq.lkAcWuphzOdE2CHP1E.2/hv1sthhTZ2Z57zOQR7ea', // 111111

        'remember_token' => Str::random(10),

        'verify_token' => $active ? null : Str::uuid(),

        //'status' => User::STATUS_ACTIVE,
        'status' => $statusActive ? User::STATUS_ACTIVE : User::STATUS_WAIT,
        'role' => $active ? $faker->randomElement([User::ROLE_USER, User::ROLE_ADMIN]) : User::ROLE_USER,

        'phone_verify_token' => $phoneActive ? null : Str::uuid(),
        'phone_verify_token_expire' => $phoneActive ? null : Carbon::now()->addSeconds(300),
    ];
});
