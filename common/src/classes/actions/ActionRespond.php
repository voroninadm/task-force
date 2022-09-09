<?php


namespace taskforce\classes\actions;

use taskforce\classes\Task;

class ActionRespond extends AbstractAction
{
    public function __construct()
    {
        $this->title = 'Откликнуться';
        $this->internalName = 'respond';
    }


    public static function isAvailable(Task $task, int $activeId): bool
    {
        if ($task->currentStatus !== Task::STATUS_NEW) {
            return false;
        }

        if ($activeId !== $task->customerId && $activeId !== $task->performerId) {
            return true;
        }
    }
}