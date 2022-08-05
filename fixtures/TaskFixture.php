<?php


namespace app\fixtures;

use app\models\Task;
use yii\test\ActiveFixture;


class TaskFixture extends ActiveFixture
{
    public $modelClass = Task::class;
}