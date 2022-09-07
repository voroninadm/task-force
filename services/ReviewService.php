<?php


namespace app\services;


use app\models\CreateReviewForm;
use app\models\Review;
use app\models\Task;
use app\models\User;

class ReviewService
{
    public function createReview(CreateReviewForm $form, Task $task): Review
    {
        $userService = new UserService();
        $transaction = Review::getDb()->beginTransaction();

        try {
            $review = new Review();
            $review->loadDefaultValues();
            $review->task_id = $form->task_id;
            $review->author_id = $form->author_id;
            $review->user_id = $form->user_id;
            $review->grade = $form->grade;
            $review->description = $form->description;
            $review->save();

            $task->status = Task::STATUS_DONE;
            $task->update();

            $performer = $review->user;
            $performer->rating = $userService->countUserPerformerRating($performer);
            $performer->status = User::STATUS_FREE;
            $performer->update();

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $review;
    }

}