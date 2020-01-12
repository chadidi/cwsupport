<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Tag;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Tag::class, function (Faker $faker) {
    $tag = $faker->word;
    return [
        'name' => $tag,
        'slug' => (new Tag)->createSlug($tag),
    ];
});
