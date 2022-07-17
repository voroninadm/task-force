<?php


namespace taskforce\classes\actions;

use taskforce\classes\Task;

class ActionDecline extends AbstractAction
{
    public function __construct()
    {
        $this->title = 'Отказаться';
        $this->internalName = 'decline';
    }

    public static function isAvailable(Task $task, int $activeId): bool
    {
        if ($task->currentStatus !== Task::STATUS_IN_WORK) {
            return false;
        }

        return $activeId === $task->performerId;
    }
}