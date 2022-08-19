<?php


namespace app\services;


use app\models\Task;
use app\models\TaskFilterForm;
use yii\db\ActiveQuery;

class TasksFilterServices
{
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
}