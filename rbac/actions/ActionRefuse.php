<?php


namespace app\rbac\actions;


use app\models\Task;
use app\models\User;

/**
 * Class ActionRefuse - performer can refuse 'in_work' task
 * @package app\rbac\actions
 */
class ActionRefuse extends AbstractAction
{

    public static function isCurrentUserCanAct(User $user, Task $task): bool
    {
        return $user->id === $task->performer_id && $task->status === Task::STATUS_IN_WORK;
    }
}