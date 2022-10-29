<?php

$faker = Faker\Factory::create('ru_RU');

return [
    'url' => "/img/avatars/{$faker->numberBetween(1, 5)}.png"
];