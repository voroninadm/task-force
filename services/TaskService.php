<?php

namespace app\services;

use app\models\CreateTaskForm;
use app\models\Task;
use app\models\TaskFilterForm;
use app\models\User;
use Yii;
use yii\db\ActiveQuery;

class TaskService
{
    /**
     * Tasks filter service
     * @param TaskFilterForm $form
     * @return ActiveQuery
     */
    public function filterTasks(TaskFilterForm $form): ActiveQuery
    {
        $query = Task::find()
            ->where(['status' => Task::STATUS_NEW]);

        if ((int) !empty($form->categories)) {
            $query->andWhere(['category_id' => $form->categories]);
        }

        if ((int) !empty($form->withoutPerformer)) {
            $query->andWhere(['performer_id' => null]);
        }

        if ((int) $form->period !== 0) {
            $query->andWhere("public_date > NOW() - INTERVAL :period HOUR", [
                ':period' => (int) $form->period]);
        }

        return $query;
    }

    /**
     * Task create service
     * @param CreateTaskForm $form
     * @return Task
     */
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

    /**
     * cancel new task service
     * @param Task $task
     * @throws \yii\db\StaleObjectException
     */
    public function cancelTask(Task $task): void
    {
        $task->status = Task::STATUS_CANCELED;
        $task->update();
    }
}