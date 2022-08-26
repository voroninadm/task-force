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
        $loginForm = new LoginForm();

        //Ajax form validation
        if (Yii::$app->request->isAjax && $loginForm->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($loginForm);
        }

        //login and redirect
        if ($loginForm->load(Yii::$app->request->post()) && $loginForm->validate())
        {
            $user = $loginForm->getUser();
            Yii::$app->user->login($user);
            $this->redirect(['/tasks']);
        }

        $this->view->title = 'Главная || TaskForce';

        return $this->render('index',[
            'loginForm' => $loginForm
        ]);
    }
}