<?php


namespace app\controllers;


use app\models\Task;
use yii\web\Controller;

class TasksController extends Controller
{

    public function actionIndex(): ?string
    {
        $tasks = Task::find()->where(['status' => 'new'])->orderBy("public_date DESC")->all();

        return $this->render('index', ['models' => $tasks]);
    }

}