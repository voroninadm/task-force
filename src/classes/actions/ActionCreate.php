<?php


namespace taskforce\classes\actions;

use taskforce\classes\Task;

class ActionCreate extends AbstractAction
{
    public function __construct()
    {
        $this->title = 'Новое';
        $this->internalName = 'new';
    }

    public static function isAvailable(Task $task, int $activeId): bool
    {
        return $activeId === $task->customerId;
    }
}