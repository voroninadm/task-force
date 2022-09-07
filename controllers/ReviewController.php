<?php


namespace app\controllers;


use app\models\CreateReviewForm;
use app\models\Task;
use app\services\ReviewService;
use Yii;

class ReviewController extends SecuredController
{
    public function actionCreate()
    {
        $reviewForm = new CreateReviewForm();
        $customer = Yii::$app->user->identity;
        $reviewService = new ReviewService();

        if ($reviewForm->load(Yii::$app->request->post()) && $reviewForm->validate()) {

            $task = Task::findOne($reviewForm->task_id);

            if ($customer->id === $task->customer_id) {
                $review = $reviewService->createReview($reviewForm, $task);
                return $this->redirect(['tasks/view', 'id' => $review->task_id]);
            }
        }

        return false;
    }
}