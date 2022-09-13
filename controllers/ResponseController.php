<?php


namespace app\controllers;


use app\models\CreateResponseForm;
use app\models\Response;
use app\models\Task;
use app\models\User;
use app\services\ResponseService;
use Yii;
use yii\base\Exception;

class ResponseController extends SecuredController
{
    /**
     * create new response for a task - for performer
     * @return false
     */
    public function actionCreate()
    {
        $responseForm = new CreateResponseForm();
        $responseService = new ResponseService();
        $user = Yii::$app->user->identity;

        if ($responseForm->load(Yii::$app->request->post()) && $responseForm->validate()) {

            $isPerformerMadeResponseEarlier = $responseService->checkIsPerformerNotFirstResponse($user->id,
                $responseForm->task_id);

            if ($user->is_performer === User::ROLE_PERFORMER && !$isPerformerMadeResponseEarlier) {
                $response = $responseService->createResponse($responseForm, $user);

                $this->redirect(['tasks/view', 'id' => $response->task_id]);
            }
        }

        return false;
    }

    /**
     * refuse user(performer's) response and block it - for customer
     * @param int $id
     * @return \yii\web\Response
     * @throws Exception
     */
    public function actionRefuse(int $id): \yii\web\Response
    {
        $response = Response::findOne($id);
        if (!$response) {
            throw new Exception("Отклик с Id=$id не найден");
        }

        $responseService = new ResponseService();
        $responseService->refuseResponse($response);

        return $this->redirect(['tasks/view', 'id' => $response->task_id]);
    }

    public function actionAccept(int $id): \yii\web\Response
    {
        $response = Response::findOne($id);

        if (!$response) {
            throw new Exception('Отклик с Id=$id не найден');
        }

        $task = $response->task;
        $performer = $response->performer;
        $responseService = new ResponseService();

        if (Yii::$app->user->id === $task->customer_id && $task->status === Task::STATUS_NEW) {
            $responseService->acceptResponse($task, $performer);
        }

        return $this->redirect(['tasks/view', 'id' => $task->id]);
    }
}