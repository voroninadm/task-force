<?php


namespace app\rbac;


use yii\rbac\Rule;

/**
 * Class TaskPerformerRule
 * Check User(performer) is a true performer of a task
 * @package app\rbac
 */
class TaskPerformerRule extends Rule
{
    public $name = 'TaskPerformerRule';

    public function execute($user, $item, $params): bool
    {
        return isset($params['task']) && $params['task']->performer_id === $user;
    }
}