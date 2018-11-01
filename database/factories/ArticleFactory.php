<?php

use Faker\Generator as Faker;

$factory->define(App\Article::class, function (Faker $faker) {
    $users = App\User::pluck('id')->toArray();
    return [
        'title' => $faker->word,
        'description' => $faker->paragraph,
        'image' => $faker->imageUrl,
        'user_id' => $faker->randomElement($users)
    ];
});
