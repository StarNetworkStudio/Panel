<?php

use App\Models\User;
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
    $email=$faker->unique()->safeEmail;
    return [
        'name' => $faker->name,
        'email' => $email,
        'avatar' => avatar($email),
        'email_verified_at' => now(),
        'password' => '$2y$10$RM8oaL8moeRO7ZzXQgLh7OTZoSG3ZoV29Kh2EaJChGZK9maiVYPkq', // 12345678
        'ip'=> '127.0.0.1',
        'register_at' => get_datetime_string(),
        'remember_token' => Str::random(10),
    ];
});
