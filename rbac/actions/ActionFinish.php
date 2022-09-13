<?php


namespace app\rbac\actions;


use app\models\Task;
use app\models\User;

/**
 * Class ActionFinish - customer can finish his task
 * @package app\rbac\actions
 */
class ActionFinish extends AbstractAction
{
    public static function isCurrentUserCanAct(User $user, Task $task): bool
    {
        return $user->id === $task->customer_id && $task->status === Task::STATUS_IN_WORK;
    }
}