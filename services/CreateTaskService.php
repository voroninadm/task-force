<?php

namespace app\services;

use app\models\CreateTaskForm;
use app\models\Task;
use Yii;

class CreateTaskService
{
    public function createTask(CreateTaskForm $form): Task
    {
//        $locationService = new LocationService();

        $task = new Task();
        $task->loadDefaultValues();

        $task->status = Task::STATUS_NEW;
        $task->customer_id = Yii::$app->user->id;
        $task->title = $form->title;
        $task->description = $form->description;
        $task->category_id = $form->category_id;
        $task->city_id = Yii::$app->user->identity->city_id;
        $task->price = !empty($form->budget) ? (int)$form->price : null;

//        if ($form->location !== '' && $locationService->isCityExistsInDB($form->city)) {
//            $task->city_id = $locationService->getCityIdByName($form->city);
//            $task->address = $form->address;
//            $task->coordinates = null;
//        }

        $task->deadline = $form->deadline;
        $task->save();

//        if ($form->location !== '') {
//            $locationService->setPointCoordinatesToTask($task->id, $form->lat, $form->long);
//        }

        return $task;
    }
}