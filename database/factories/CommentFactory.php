<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comment;
use Faker\Generator as Faker;
use App\User;
use App\Models\Status;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create(),
        'status_id' => factory(Status::class)->create(),
        'body' => $faker->paragraph()
    ];
});
