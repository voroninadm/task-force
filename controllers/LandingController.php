<?php


namespace app\controllers;


use app\models\LoginForm;
use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;


class LandingController extends GuestController
{
    public $layout = 'landing';

    public function actionIndex(): string|array
    {
        $this->view->title = 'Главная';

        $loginForm = new LoginForm();

        if (Yii::$app->request->getIsPost()) {
            $loginForm->load(Yii::$app->request->post());

            //Ajax form validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($loginForm);
            }

            //login and redirect
            if ($loginForm->validate()) {
                $user = $loginForm->getUser();
                Yii::$app->user->login($user);
                $this->redirect(['/tasks']);
            }
        }

            return $this->render('index', [
                'loginForm' => $loginForm
            ]);
        }

}