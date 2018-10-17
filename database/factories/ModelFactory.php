<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Thread::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->realText(30, 1),
        'params' => null,
    ];
});

$factory->define(App\Message::class, function (Faker\Generator $faker) {
    return [
        'thread_id' => 1,
        'client_id' => rand(1,3),
        'content' => $faker->realText(100, 2),
        'params' => null,
    ];
});

