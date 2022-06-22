<?php


namespace taskforce\classes;


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

    protected $customerId = 0;
    protected $performerId = 0;


    public function __construct(int $customerId, ?int $performerId = null) {
        $this->$customerId = $customerId;
        $this->$performerId = $performerId;
    }

    public function getStatusMap (): array {
        return [
            self::STATUS_NEW => 'Новое задание',
            self::STATUS_CANCELED => 'Задание отменено',
            self::STATUS_IN_WORK => 'Задание в работе',
            self::STATUS_DONE => 'Задание завершено',
            self::STATUS_FAILED => 'Задание провалено'
        ];
    }

    public function getActionsMap(): array {
        return[
            self::ACTION_CREATE => 'Создать задание',
            self::ACTION_REFUSE => 'Отменить задание',
            self::ACTION_RESPOND => 'Откликнуться на задание',
            self::ACTION_FINISH => 'Завершить задание',
            self::ACTION_DECLINE => 'Отказ от задания',
        ];
    }

    public function getNextStatus(string $action): string {
        return match ($action) {
            self::ACTION_CREATE => self::STATUS_NEW,
            self::ACTION_DECLINE => self::STATUS_FAILED,
            self::ACTION_REFUSE => self::STATUS_CANCELED,
            self::ACTION_FINISH => self::STATUS_DONE,
        };
    }

    public function getPossibleActions(string $status): ?array
    {
        $possibleActions = [
            self::STATUS_NEW => [
                self::ACTION_REFUSE,
                self::ACTION_RESPOND,
            ],
            self::STATUS_CANCELED => null,
            self::STATUS_IN_WORK => [
                self::ACTION_FINISH,
                self::ACTION_DECLINE,
            ],
            self::STATUS_DONE => null,
            self::STATUS_FAILED => null,
        ];

        return $possibleActions[$status] ?? null;
    }
}