<?php


namespace app\controllers;


use app\models\Review;
use app\models\User;
use taskforce\classes\exceptions\NotFoundHttpException;
use Yii;
use yii\web\Controller;

class UserController extends SecuredController
{
    public function actionView(int $id): string
    {
        $user = User::findOne($id);
        $currentUser = Yii::$app->user->identity;
        if (!$user) {
            throw new NotFoundHttpException("Пользователь с ID=$id не найден");
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