<?php


namespace taskforce\classes\actions;

use taskforce\classes\Task;

class ActionRefuse extends AbstractAction
{
    public function __construct()
    {
        $this->title = 'Отменить';
        $this->internalName = 'refuse';
    }

    public static function isAvailable(Task $task, int $activeId): bool
    {
        if ($task->currentStatus !== Task::STATUS_NEW) {
            return false;
        }

        return $activeId === $task->customerId;
    }
}