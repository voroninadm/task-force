<?php

$faker = Faker\Factory::create('ru_RU');

$tasks = 20;
$users_count = 15;

return [
    'task_id' => $faker->numberBetween(0, $tasks),
    'user_id' => $faker->numberBetween(0, $tasks),
    'comment' => $faker->paragraph(),
    'create_date' => $faker->dateTimeBetween('-2 days', 'now')->format('Y-m-d H:i:s'),
    'price' => $faker->numberBetween(500, 10000),
    'is_blocked' => $faker->numberBetween(0, 1)
];