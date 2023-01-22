<?php

namespace app\services;

use app\models\CreateTaskForm;
use app\models\Task;
use app\models\TaskFilterForm;
use app\models\User;
use app\rbac\actions\ActionCancel;
use app\rbac\actions\ActionFinish;
use app\rbac\actions\ActionRefuse;
use app\rbac\actions\ActionResponse;
use Yii;
use yii\base\Exception;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\helpers\Url;

class TaskService
{
    /**
     * Tasks filter service
     * @param TaskFilterForm $form
     * @return ActiveQuery
     */
    public static function filterTasks(TaskFilterForm $form): ActiveQuery
    {
        $query = Task::find()
            ->where(['status' => Task::STATUS_NEW]);

        if ((int) !empty($form->categories)) {
            $query->andWhere(['category_id' => $form->categories]);
        }

        if ((int) !empty($form->withoutPerformer)) {
            $query->andWhere(['performer_id' => null]);
        }

        if ((int) !empty($form->remote)) {
            $query->andWhere(['address' => null]);
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
        $locationService = new LocationService();

        $task = Yii::$container->get(Task::class);
        $task->loadDefaultValues();

        $task->status = Task::STATUS_NEW;
        $task->customer_id = Yii::$app->user->id;
        $task->title = $form->title;
        $task->description = $form->description;
        $task->category_id = $form->category_id;
        $task->price = !empty($form->price) ? (int)$form->price : null;

        if (!empty($form->location) && $locationService->isCityExistsInDB($form->city)) {
            $task->city_id = $locationService->getCityIdByName($form->city);
            $task->address = $form->address;
            $task->lat = $form->lat;
            $task->long = $form->long;
        }
        if (!empty($form->location) && !$locationService->isCityExistsInDB($form->city)) {
            $form->addError("Город $form->city не обнаружен. Выберите Ваш город регистрации или оставьте пустым");
        }

        $task->deadline = $form->deadline;
        $task->save();

        return $task;
    }

    /**
     * cancel new task service (by customer)
     * @param Task $task
     * @throws \yii\db\StaleObjectException
     */
    public function cancelTask(Task $task): void
    {
        $task->status = Task::STATUS_CANCELED;
        $task->update();
    }

    /**
     * refuse task (by task performer)
     * set performer free with -rating and set task status as failed
     * @param Task $task
     * @throws \yii\db\Exception|\Throwable
     */
    public function refuseTask(Task $task): void
    {
        $userService = new UserService();
        $performer = $task->performer;

        $transaction = Task::getDb()->beginTransaction();

        try {
            $task->status = Task::STATUS_FAILED;
            $task->update();
            $performer->updateCounters(['failed_task' => 1]);
            $performer->rating = $userService->countUserPerformerRating($performer);
            $performer->is_busy = User::STATUS_FREE;
            $performer->update();

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * get available actions for task based on User role and current viewed task
     * @param User $user
     * @param Task $task
     * @return array
     * @throws Exception
     */
    public static function getAvailableTaskActions(User $user, Task $task): array
    {
        $actionsLinks = [];

        switch ($task->status) {
            case Task::STATUS_NEW:
                if (ActionCancel::isCurrentUserCanAct($user, $task)) {
                    $actionsLinks[] = '<a href="' . Url::to(['tasks/cancel', 'id' => $task->id]) . '" class="button button--yellow action-btn">Отменить задание</a>';
                }

                if (ActionResponse::isCurrentUserCanAct($user, $task)) {
                    $actionsLinks[] = '<a href="#" class="button button--blue action-btn" data-action="act_response">Откликнуться на задание</a>';
                }
                break;

            case Task::STATUS_IN_WORK:
                if (ActionFinish::isCurrentUserCanAct($user, $task)) {
                    $actionsLinks[] = '<a href="#" class="button button--pink action-btn" data-action="completion">Завершить задание</a>';
                }

                if (ActionRefuse::isCurrentUserCanAct($user, $task)) {
                    $actionsLinks[] = '<a href="#" class="button button--orange action-btn" data-action="refusal">Отказаться от задания</a>';
                }
                break;

            case Task::STATUS_FAILED:
            case Task::STATUS_DONE:
            case Task::STATUS_CANCELED:
                return [];
            default:
                throw new Exception("Не определить список доступных действий ");
        }

        return $actionsLinks;
    }

    /**
     *
     * @param User $user
     * @param string $status
     */
    public static function getMyTasks(User $user, string $status): ActiveQuery
    {
        $role = $user->is_performer;
        $query = Task::find();

        switch ($status) {
            case 'new':
                $query->andWhere(['status' => Task::STATUS_NEW]);
                break;
            case 'in_work':
                $query->andWhere(['status' => Task::STATUS_IN_WORK]);
                break;
            case 'overdue':
                $query->andWhere(['status' => Task::STATUS_IN_WORK]);
                $query->andWhere(['<', 'deadline', new Expression('NOW()')]);
                break;
            case 'closed':
                $query->orWhere(['status' => Task::STATUS_DONE]);
                $query->orWhere(['status' => Task::STATUS_FAILED]);
                if ($role === User::ROLE_CUSTOMER) {
                    $query->orWhere(['status' => Task::STATUS_CANCELED]);
                }
                break;
        }

        if ($role === User::ROLE_CUSTOMER) {
            $query->AndWhere(['customer_id' => $user->id]);
        }

        if ($role === User::ROLE_PERFORMER) {
            $query->AndWhere(['performer_id' => $user->id]);
        }

        return $query->with('city', 'category');
    }
}