<?php


namespace app\rbac;


use app\models\Response;
use yii\rbac\Rule;

/**
 * Class PerformerResponseRule
 * Check User(performer) can create new response for a task
 * @package app\rbac
 */
class PerformerResponseRule extends Rule
{
    public $name = 'performerResponseRule';

    public function execute($user, $item, $params): bool
    {
        return isset($params['task']) && !(Response::find()->where(['user_id' => $user, 'task_id' => $params['task']->id])->exists());
    }
}