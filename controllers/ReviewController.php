<?php


namespace app\controllers;


use app\models\CreateReviewForm;
use app\models\Task;
use app\services\ReviewService;
use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;

class ReviewController extends SecuredController
{
    public function actionCreate()
    {
        $reviewForm = new CreateReviewForm();
        $customer = Yii::$app->user->identity;
        $reviewService = new ReviewService();

        if(Yii::$app->request->getIsPost()) {
            $reviewForm->load(Yii::$app->request->post());

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($reviewForm);
            }

            if ($reviewForm->validate()) {
                $task = Task::findOne($reviewForm->task_id);

                if ($customer->id === $task->customer_id) {
                    $review = $reviewService->createReview($reviewForm, $task);
                    return $this->redirect(['tasks/view', 'id' => $review->task_id]);
                }
            }
        }

        return false;
    }
}