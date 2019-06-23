<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

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
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'staff_id' => $faker->unique()->bothify('???###'),         
        'admin_user' => $faker->boolean($chanceOfGettingTrue = 50),
        'currentyear_holiday_entitlement' => $faker->randomFloat($nbMaxDecimals = 2, $min = 24.0, $max = 24.0),
        'currentyear_holiday_used'  => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 0),
        'nextyear_holiday_entitlement'  => $faker->randomFloat($nbMaxDecimals = 2, $min = 24.0, $max = 24.0) ,
        'nextyear_holiday_used'  => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 0),
        'pending_holiday_used'  => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 0),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});
