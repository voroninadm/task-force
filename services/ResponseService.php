<?php


namespace app\services;


use app\models\CreateResponseForm;
use app\models\Response;
use app\models\Task;
use app\models\User;

class ResponseService
{
    /**
     * create new response (for performer)
     * @param CreateResponseForm $form
     * @param User $user
     * @return Response
     */
    public function createResponse(CreateResponseForm $form, User $user): Response
    {
        $response = new Response();
        $response->loadDefaultValues();
        $response->task_id = intval($form->task_id);
        $response->user_id = $user->id;
        $response->comment = $form->comment;
        $response->price = $form->price;
        $response->save();

        return $response;
    }

    /**
     * accept response, set response's author as task performer and set task 'in work'
     * (for customer)
     */
    public function acceptResponse(Task $task, User $performer): void
    {
        $transaction = Task::getDb()->beginTransaction();

        try {
            $task->status = Task::STATUS_IN_WORK;
            $task->performer_id = $performer->id;
            $task->save();

            $performer->is_busy = User::STATUS_BUSY;
            $performer->update();

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * set response as blocked
     * refuse response and block this
     * (for customer)
     */
    public function refuseResponse(Response $response): void
    {
        $response->is_blocked = 1;
        $response->update();
    }

    /**
     * check is performer made response for a task earlier or not
     * @param int $userId
     * @param int $taskId
     * @return bool
     */
    public function checkIsPerformerNotFirstResponse(int $userId, int $taskId): bool
    {
        return Response::find()->where(['user_id' => $userId, 'task_id' => $taskId])->exists();
    }
}