<?php


namespace taskforce\classes\actions;

use taskforce\classes\Task;

abstract class AbstractAction
{
    protected string $title;
    protected string $internalName;

    public function getTitle(): string {
        return $this->title;
    }

    public function getInternalName(): string
    {
        return $this->internalName;
    }

    abstract public static function isAvailable(Task $task, int $activeId): bool;
}