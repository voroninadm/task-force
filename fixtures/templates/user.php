<?php
/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

$faker = Faker\Factory::create('ru_RU');
$citiesCount = 1087;


return [
    'name' => $faker->name(),
    'birth_date' => $faker->date(),
    'city_id' => $faker->numberBetween(1, $citiesCount),
    'reg_date' => $faker->dateTimeBetween('-1 week', 'now')->format('Y-m-d H:i:s'),
    'avatar_file_id' => $faker->unique()->numberBetween(1, 100),
    'email' => $faker->unique()->email(),
    'password' => Yii::$app->getSecurity()->generatePasswordHash('password'),
    'phone' => $faker->e164PhoneNumber(),
    'telegram' => "@{$faker->userName()}",
    'done_task' => $faker->numberBetween(1, 30),
    'failed_task' => $faker->numberBetween(0, 5),
    'rating' => $faker->randomFloat(2, 0, 5),
    'is_performer' => $faker->numberBetween(0, 1),
    'is_private' => $faker->numberBetween(0, 1),
    'is_busy' => $faker->numberBetween(0, 1),
];