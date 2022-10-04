<?php


namespace app\controllers;


use app\models\Review;
use app\models\User;
use Exception;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;


class UserController extends SecuredController
{
    public function actionView(int $id): Response|string
    {
        $user = User::findOne($id);

        $currentUser = Yii::$app->user->identity;
        if (!$user || $user->is_performer === User::ROLE_CUSTOMER) {
            throw new NotFoundHttpException("Пользователь с Id='{$id}' не найден или является заказчиком");
        }
        $this->view->title = "Профайл пользователя $user->name";

        $reviews = Review::find()
            ->where(['user_id' => $id])
            ->all();

        return $this->render('view', [
            'user' => $user,
            'currentUser' => $currentUser,
            'categories' => $user->categories,
            'reviews' => $reviews
        ]);
    }

    public function actionLogout(): void {
        Yii::$app->user->logout();

        $this->redirect(['/landing']);
    }
}