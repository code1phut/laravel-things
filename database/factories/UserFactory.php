<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Enums\UserStatus;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(User::class, function (Faker $faker) {
    return [
        'full_name' => $faker->name,
        'user_name' => $faker->userName,
        'phone_number' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => \Illuminate\Support\Facades\Hash::make('123456'), // password
        'status' => UserStatus::ACTIVE,
        'remember_token' => Str::random(10),
    ];
});
