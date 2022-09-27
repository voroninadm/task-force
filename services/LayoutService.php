<?php


namespace app\services;


class LayoutService
{
    public static function addClassToMain(string $url): string
    {
        $classMap = [
            'tasks/create' => 'main-content--center',
            'profile/index' => 'main-content--left',
            'profile/security' => 'main-content--left',
        ];

        return $classMap[$url] ?? '';
    }
}