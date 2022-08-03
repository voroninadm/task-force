<?php

$faker = Faker\Factory::create('ru_RU');

$tasks = 20;
$files = 30;

return [
    'task_id' => $faker->numberBetween(0, $tasks),
    'file_id' => $faker->numberBetween(0, $files)
];