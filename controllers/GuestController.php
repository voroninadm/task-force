<?php


namespace app\controllers;


use yii\filters\AccessControl;
use yii\web\Controller;

class GuestController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'allow' => false,
                        'roles' => ['@'],
                        'denyCallback' => fn() => $this->redirect(['/tasks'])
                    ]
                ]
            ]
        ];
    }
}