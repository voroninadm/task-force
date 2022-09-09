<?php


namespace app\rbac\actions;


use app\models\Task;
use app\models\User;

/**
 * Class ActionCancel - customer can cancel his new task
 * (rbac customerIsCreatorOfNewTaskRule)
 * @package app\rbac\actions
 */
class ActionCancel extends AbstractAction
{

    public static function isCurrentUserCanAct(User $user, Task $task): bool
    {
        return $user->id === $task->customer_id && $task->status === Task::STATUS_NEW;
    }
}