<?php

return [
    //project params
    'tasksListSize' => 5,   //tasks per page for pagination
    'starRating'=> 5,   //stars count for widget rating
    'userDefaultAvatarPath' => '/img/avatars/1.png', // default user avatar
    'maxFilesToTask' => 5, //max files to create task

    //user security
    'minUserPasswordLength' => 5,

    //yandex geocoder
    'apiYandexGeocoderKey' => '...',

    //vk OAuth
    'vkClientId' => '...',
    'vkSecretKey' => '...',


    //other params
    'bsDependencyEnabled' => false, // this will not load Bootstrap CSS and JS for all Krajee extension (STAR RATING),

    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',

];