<?php


namespace app\rbac;



use yii\rbac\Rule;

/**
 * Class CustomerIsTaskCreatorRule
 * Check User(customer) is the creator of the task
 * @package app\rbac
 */
class CustomerIsTaskCreatorRule extends Rule
{
    public $name = 'customerIsTaskCreatorRule';

    public function execute($user, $item, $params): bool
    {
        return isset($params['task']) && $params['task']->customer_id === $user;
    }
}