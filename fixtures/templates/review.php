<?php

$faker = Faker\Factory::create('ru_RU');

$tasks = 20;

return [
    'description' => $faker->paragraph(),
    'create_date' => $faker->dateTimeBetween('now', '+1 week')->format('Y-m-d H:i:s'),
    'grade' => $faker->numberBetween(1, 5),
    'task_id' => $faker->numberBetween(0, $tasks)
];