<?php

$faker = Faker\Factory::create('ru_RU');

$users = 15;
$categories = 8;

return [
    'user_id' => $faker->numberBetween(0, $users),
    'category_id' => $faker->numberBetween(0, $categories)
];