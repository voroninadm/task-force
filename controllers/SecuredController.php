<?php


namespace app\controllers;


use yii\filters\AccessControl;
use yii\web\Controller;

class SecuredController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['?'],
                        ],
                        [
                            'allow' => false,
                            'roles' => ['@'],
                            'denyCallback' => function ($rule, $action) {
                                $this->redirect(['tasks/index']);
                            }
                        ]
                ]
            ]
        ];
    }
}