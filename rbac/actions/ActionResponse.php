<?php


namespace app\rbac\actions;


use app\models\Task;
use app\models\User;
use app\services\ResponseService;

/**
 * Class ActionResponse - performer can create new(first) response
 * (rbac performerResponseRule)
 * @package app\rbac\actions
 */
class ActionResponse extends AbstractAction
{

    public static function isCurrentUserCanAct(User $user, Task $task): bool
    {
        $isPerformerAlreadyMadeResponse = (new ResponseService())->checkIsPerformerNotFirstResponse($user->id, $task->id);
        return 
            !$isPerformerAlreadyMadeResponse
            && $user->is_performer === User::ROLE_PERFORMER
            && $task->status === Task::STATUS_NEW;
    }
}