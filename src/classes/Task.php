<?php


namespace taskforce\classes;

use taskforce\classes\actions\ActionDecline;
use taskforce\classes\actions\ActionFinish;
use taskforce\classes\actions\ActionRefuse;
use taskforce\classes\actions\ActionRespond;

class Task
{
    const STATUS_NEW = 'new';
    const STATUS_CANCELED = 'canceled';
    const STATUS_IN_WORK = 'in_work';
    const STATUS_DONE = 'done';
    const STATUS_FAILED = 'failed';

    const ACTION_CREATE = 'create';
    const ACTION_DECLINE = 'decline';
    const ACTION_RESPOND = 'respond';
    const ACTION_FINISH = 'finish';
    const ACTION_REFUSE = 'refuse';

    public int $customerId;
    public int $performerId;
    public string $currentStatus;


    public function __construct(int $customerId, ?int $performerId = null, string $currentTaskStatus = self::STATUS_NEW)
    {
        $this->$currentTaskStatus = $currentTaskStatus;
        $this->$customerId = $customerId;
        $this->$performerId = $performerId;
    }

    public function getStatusMap(): array
    {
        return [
            self::STATUS_NEW => 'Новое задание',
            self::STATUS_CANCELED => 'Задание отменено',
            self::STATUS_IN_WORK => 'Задание в работе',
            self::STATUS_DONE => 'Задание завершено',
            self::STATUS_FAILED => 'Задание провалено'
        ];
    }

    public function getActionsMap(): array
    {
        return [
            self::ACTION_CREATE => 'Создать задание',
            self::ACTION_REFUSE => 'Отменить задание',
            self::ACTION_RESPOND => 'Откликнуться на задание',
            self::ACTION_FINISH => 'Завершить задание',
            self::ACTION_DECLINE => 'Отказ от задания',
        ];
    }

    public function getNextStatus(string $action): string
    {
        if (!array_key_exists($action, $this->getActionsMap())) {
            exit("Вызвано некорректное действие: $action");
        }
        return match ($action) {
            ActionDecline::class => self::STATUS_FAILED,
            ActionRefuse::class => self::STATUS_CANCELED,
            ActionFinish::class => self::STATUS_DONE,
            ActionRespond::class => null
        };
    }

    public function getPossibleActions(string $status): ?array
    {
        $possibleActions = [
            self::STATUS_NEW => [ActionRefuse::class, ActionRespond::class],
            self::STATUS_CANCELED => null,
            self::STATUS_IN_WORK => [ActionFinish::class, ActionDecline::class],
            self::STATUS_DONE => null,
            self::STATUS_FAILED => null,
        ];

        return $possibleActions[$status] ?? [];
    }
}