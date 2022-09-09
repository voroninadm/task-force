<?php


namespace app\rbac\actions;


use app\models\Task;
use app\models\User;

/**
 * Class AbstractAction
 * what current(logged in) user can do with task
 * @package app\rbac\actions
 */
abstract class AbstractAction
{
    abstract public static function isCurrentUserCanAct (User $user, Task $task): bool;
}