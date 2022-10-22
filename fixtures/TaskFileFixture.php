<?php


namespace app\fixtures;

use yii\test\ActiveFixture;

class TaskFileFixture extends ActiveFixture
{
    public $tableName = 'task_file';
    public $dataFile = __DIR__ . '/data/taskFile.php';
}