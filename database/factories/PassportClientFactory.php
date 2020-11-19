<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Laravel\Passport\Client;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'USER_ID' => null,
        'NAME' => $this->faker->company,
        'SECRET' => Str::random(40),
        'REDIRECT' => $this->faker->url,
        'PERSONAL_ACCESS_CLIENT' => false,
        'PASSWORD_CLIENT' => false,
        'REVOKED' => false,
    ];
});

$factory->state(Client::class, 'password_client', function (Faker $faker) {
    return [
        'PERSONAL_ACCESS_CLIENT' => false,
        'PASSWORD_CLIENT' => true,
    ];
});
