<?php


namespace app\rbac;


use app\models\Task;
use yii\rbac\Rule;

/**
 * Class CustomerIsCreatorOfNewTaskRule
 * Check User(customer) is the creator of the task and status of this task is 'new'
 * @package app\rbac
 */
class CustomerIsCreatorOfNewTaskRule extends Rule
{
    public $name = 'CustomerIsCreatorOfNewTaskRule';

    public function execute($user, $item, $params): bool
    {
        return isset($params['task']) && $params['task']->customer_id === $user && $params['task']->status === Task::STATUS_NEW;
    }
}