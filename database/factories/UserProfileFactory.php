<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\UserProfile;
use Faker\Generator as Faker;

$factory->define(UserProfile::class, function (Faker $faker) {
    return [
        'user' => User::orderBy('id', 'DESC')->first(),
        'image' => 'https://placekitten.com/200/300',
        'description' => $faker->text($maxNbChars = 200),
        'company' => $faker->word
    ];
});
