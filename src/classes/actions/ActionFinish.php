<?php


namespace taskforce\classes\actions;

use taskforce\classes\Task;

class ActionFinish extends AbstractAction
{
    public function __construct()
    {
        $this->title = 'Завершить';
        $this->internalName = 'finish';
    }

    public static function isAvailable(Task $task, int $activeId): bool
    {
        if ($task->currentStatus !== Task::STATUS_IN_WORK) {
            return false;
        }

        return $activeId === $task->customerId;
    }
}