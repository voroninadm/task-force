<?php

$faker = Faker\Factory::create('ru_RU');

$category_count = 8;
$cities_count = 1087;
$users_count = 15;

return [
    'public_date' => $faker->dateTimeBetween('-1 week', 'now')->format('Y-m-d H:i:s'),
    'status' => $faker->randomElement(['new', 'canceled', 'in_work', 'done', 'failed']),
    'title' => $faker->sentence(),
    'description' => $faker->paragraph(),
    'category_id' => $faker->numberBetween(1, $category_count),
    'city_id' => $faker->numberBetween(1, $cities_count),
    'address' => $faker->address(),
    'lat' => $faker->latitude($min = -90, $max = 90),
    'lng' => $faker->longitude($min = -180, $max = 180),
    'price' => $faker->numberBetween(500, 10000),
    'deadline' => $faker->dateTimeBetween('now', '+4 week')->format('Y-m-d H:i:s'),
    'customer_id' => $faker->numberBetween(1, $users_count),
    'performer_id' => $faker->numberBetween(0, $users_count)
];