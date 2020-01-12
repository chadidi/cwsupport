<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Issue;
use Faker\Generator as Faker;

$factory->define(Issue::class, function (Faker $faker) {
    $user = factory(User::class)->create();
    return [
        'user_id' => $user->id,
        'title' => $faker->sentence,
        'description' => $faker->text,
        'status' => $faker->randomElement(['SUBMITTED', 'IN_PROGRESS', 'RESOLVED', 'CLOSED']),
    ];
});
