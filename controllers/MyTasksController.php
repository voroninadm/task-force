<?php


namespace app\controllers;


use yii\web\Controller;

class MyTasksController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}